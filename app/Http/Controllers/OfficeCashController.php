<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\TRNDTL;
use App\Models\ErpParam;
use App\Models\OfficeCash;
use Illuminate\Http\Request;
use App\Models\AccountMaster;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class OfficeCashController extends Controller
{
    public function index()
    {
        $erpParams = ErpParam::with('level2')->get();
        $accountMasters = collect();
        if ($erpParams->isNotEmpty()) {
            $cashLevelId = $erpParams->first()->cash_level;
            $accountMasters = AccountMaster::where('level2_id', $cashLevelId)->get();
        }
        
        $accounts = AccountMaster::all();
        return view('office_cash.list',get_defined_vars());
    }
    public function store(Request $request)
    {
        
        $request->validate([
            'v_type' => 'required|string',
            'entries' => 'required|array',
            'entries.*.date' => 'required|date',
            'entries.*.cash' => 'required|string',
            'entries.*.account' => 'required|string',
            'entries.*.description' => 'required|string',
           
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('uploads', $fileName, 'public');
        }


$lastEntry = TRNDTL::where('v_type', 'OC')->max('v_no');
$newInvoiceNumber = $lastEntry ? ($lastEntry + 1) : 1;




        foreach ($request->entries as $index => $entry) {
            TRNDTL::create([
    'v_no' => $newInvoiceNumber,
    'v_type' => 'OC',
    'preparedby' => auth()->user()->name, // Get the user's name instead of ID
    'date' => now(), // Using Carbon's now()
    'cash_id' => $entry['cash'],
    'account_id' => $entry['account'],
    'description' => $entry['description'],
    'debit' => $entry['debit'],
    'credit' => '0',
    'status' => 'unofficial',
    'file_id' => $filePath,
]);
        }

        return redirect()->route('office_cash.reports')->with('success', '' . $request->v_type . '-' . $newInvoiceNumber . ' has been saved successfully.');
    }


    public function reports(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $status = $request->input('status');
    $v_no = $request->input('v_no');
    $account_id = $request->input('account_id');

    $query = TRNDTL::where('v_type', 'OC')->with('accounts');

    if ($startDate && $endDate) {
        $query->whereBetween('date', [$startDate, $endDate]);
    }

    if ($status) {
        $query->where('status', $status);
    }
    
     if ($v_no) {
        $query->where('v_no', $v_no);
    }
    if ($account_id) {
        $query->where('account_id', $account_id);
    }
    
   $trndtls = $query->orderBy('date', 'desc')
                 ->orderBy('v_no', 'desc')
                 ->paginate(20)
                 ->withQueryString();



    $accountMasters = AccountMaster::all();
       $vNoList = TRNDTL::where('v_type', 'OC')->pluck('v_no')->unique()->toArray();
     $accountIdList = TRNDTL::where('v_type', 'OC')->pluck('account_id')->unique()->toArray();

    return view('office_cash.index', [
        'trndtls' => $trndtls,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'status' => $status, 
        'accountMasters' => $accountMasters,
          'vNoList' => $vNoList,
        'accountIdList' => $accountIdList,
    ]);
}


public function edit($v_no)
{
    $voucher = TRNDTL::where('v_no', $v_no)
                ->where('v_type', 'OC')
                ->get(); 
                
    $accounts = AccountMaster::all();

    $erpParams = ErpParam::with('level2')->get();

    $accountMasters = collect();

    if ($erpParams->isNotEmpty()) {
        $cashLevelId = $erpParams->first()->cash_level;
        $accountMasters = AccountMaster::where('level2_id', $cashLevelId)->get();
    }

    return view('office_cash.edit', compact('voucher', 'accountMasters', 'accounts'));
}



public function update(Request $request, $id)
{
    
   
    DB::transaction(function () use ( $id, $request) {

      

        // Handle file once
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('uploads', $fileName, 'public');
        }

      
            TRNDTL::create([
                'v_no'        => $id,
                'v_type'      => 'OC',
                'date'        => $request->date,
                'preparedby'  => auth()->user()->name,
                'cash_id'     => $request->account_id,
                'account_id'  => $request->entryParty,
                'description' => $request->description??'N/A',
                'debit'       => $request->amount,
                'credit'      => 0,
                'status'      => 'unofficial',
                'file_id'     => $filePath,
            ]);
        
    });

    return back()->with('success', 'Office Cash updated successfully.');
}

public function destroy($id)
{
    $trndtl = TRNDTL::where('v_type', 'OC')
                    ->where('id', $id)
                    ->firstOrFail();

    $trndtl->delete();

    return redirect()->route('office_cash.reports')->with('success', 'Transaction deleted successfully!');
}

public function delete($id)
{
    $trndtl = TRNDTL::where('v_type', 'OC')
                    ->where('id', $id)
                    ->firstOrFail();

    $trndtl->delete();
    
    return redirect()->route('office_cash.reports')->with('success', 'Transaction deleted successfully!');
}
}
