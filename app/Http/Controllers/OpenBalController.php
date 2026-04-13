<?php

namespace App\Http\Controllers;

use App\Models\TRNDTL;
use App\Models\ItemMaster;
use Illuminate\Http\Request;
use App\Models\AccountMaster;
use App\Models\OpenBal;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OpenBalController extends Controller
{
    public function index()
    {
        $accounts = AccountMaster::all();

        return view('open_bal.list', get_defined_vars());
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'entry_account_title_id.*' => 'required|exists:accounts,id',
            'entry_debit' => 'required|array',
            'entry_credit' => 'required|array',
            'entry_date' => 'required|array', 
            'description' => 'nullable|array',
        ]);

        if ($request->total_debit != $request->total_credit) {
            return redirect()->back()->with('error', 'Total debit and credit amounts must be equal.');
        }

        $lastEntry = TRNDTL::where('v_type', 'OB')
            ->orderBy('id', 'desc')
            ->first();

        $lastInvoiceNumber = $lastEntry && is_numeric($lastEntry->v_no) ? (int) $lastEntry->v_no : 0;

        $newInvoiceNumber = $lastInvoiceNumber + 1; // Move outside the loop

        foreach ($request->entry_account_title as $index => $accountTitle) {
            TRNDTL::create([
                'v_no' => $newInvoiceNumber,
                'account_id' => $accountTitle,
                'status' => 'unofficial',
                'debit' => $request->entry_debit[$index] ?? 0,
                'credit' => $request->entry_credit[$index] ?? 0,
                'date' => $request->entry_date[$index],
                'v_type' => 'OB',
                'preparedby' => auth()->user()->name,
                'description' => $request->entry_description[$index] ?? '',
            ]);
        }

        return redirect()->route('open_bal.reports')->with('success', $request->v_type . '-' . $newInvoiceNumber . ' has been saved successfully.');
    }

    public function reports(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $v_no = $request->input('v_no');
        $description = $request->input('description');
        
        $query = TRNDTL::where('v_type', 'OB')->with('accounts');

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($v_no) {
            $query->where('v_no', $v_no);
        }
        
        if ($description) {
            $query->where('description', 'LIKE', "%$description%");
        }
        
        $trndtls = $query->orderByRaw('DATE(date) DESC')
                     ->orderBy('v_no', 'desc')
                     ->get();

        $vNoList = TRNDTL::where('v_type', 'OB')->pluck('v_no')->unique()->toArray();
        $descriptionList = TRNDTL::where('v_type', 'OB')->pluck('description')->unique()->toArray();
        $accountMasters = AccountMaster::all();

        return view('open_bal.index', [
            'trndtls' => $trndtls,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status,
            'accountMasters' => $accountMasters,
            'vNoList' => $vNoList,
            'descriptionList' => $descriptionList,
        ]);
    }

    // Show the edit form for all entries of a voucher
    public function edit($v_no)
    {
        $accounts = AccountMaster::all();
        $voucher = TRNDTL::where('v_no', $v_no)->where('v_type', 'OB')->get();
        return view('open_bal.edit', [
            'voucher' => $voucher,
            'accounts' => $accounts,
        ]);
    }

    public function update(Request $request, $v_no)
    {
        $request->validate([
            'entry_id'             => 'array',
            'entry_id.*'           => 'nullable|integer',
            'entry_account_title'  => 'required|array|min:1',
            'entry_account_title.*' => 'required|exists:account_masters,id',
            'entry_debit'          => 'required|array',
            'entry_debit.*'        => 'nullable|numeric',
            'entry_credit'         => 'required|array',
            'entry_credit.*'       => 'nullable|numeric',
            'entry_date'           => 'required|array',
            'entry_date.*'         => 'required|date',
            'description'          => 'nullable|array',
            'description.*'        => 'nullable|string|max:255',
            'delete_entry_ids'     => 'array',
            'delete_entry_ids.*'   => 'integer',
        ]);

        // Recompute totals
        $debitTotal  = array_sum(array_map('floatval', $request->entry_debit));
        $creditTotal = array_sum(array_map('floatval', $request->entry_credit));

        if ($debitTotal !== $creditTotal) {
            return back()->with('error', 'Total debit and credit amounts must be equal.');
        }

        DB::transaction(function () use ($request, $v_no) {
            // Delete all old voucher entries for this voucher
            TRNDTL::where('v_no', $v_no)
                ->where('v_type', 'OB')
                ->delete();

            // Iterate through each form row individually
            foreach ($request->entry_account_title as $index => $accountTitle) {
                $debitEntry       = (float)($request->entry_debit[$index] ?? 0);
                $creditEntry      = (float)($request->entry_credit[$index] ?? 0);
                $entryDate        = $request->entry_date[$index] ?? null;
                $descriptionEntry = $request->description[$index] ?? '';

                // Create a row for debit if non-zero
                if ($debitEntry > 0) {
                    TRNDTL::create([
                        'v_no'        => $v_no,
                        'account_id'  => $accountTitle,
                        'debit'       => $debitEntry,
                        'credit'      => 0,
                        'status'      => 'unofficial',
                        'date'        => $entryDate,
                        'v_type'      => 'OB',
                        'preparedby'  => auth()->user()->name,
                        'description' => $descriptionEntry,
                    ]);
                }
                
                // Create a row for credit if non-zero
                if ($creditEntry > 0) {
                    TRNDTL::create([
                        'v_no'        => $v_no,
                        'account_id'  => $accountTitle,
                        'debit'       => 0,
                        'credit'      => $creditEntry,
                        'status'      => 'unofficial',
                        'date'        => $entryDate,
                        'v_type'      => 'OB',
                        'preparedby'  => auth()->user()->name,
                        'description' => $descriptionEntry,
                    ]);
                }
            }
        });

        return redirect()->route('open_bal.reports')->with('success', 'OB-' . $v_no . ' has been updated successfully.');
    }

    public function destroy($v_no)
    {
        // Delete all rows for the voucher number
        $exists = TRNDTL::where('v_type', 'OB')
            ->where('v_no', $v_no)
            ->exists();

        if (!$exists) {
            return redirect()->route('open_bal.reports')
                ->with('error', 'Balance not found.');
        }

        DB::transaction(function () use ($v_no) {
            TRNDTL::where('v_type', 'OB')
                ->where('v_no', $v_no)
                ->delete();
        });

        return redirect()->route('open_bal.reports')
            ->with('success', 'OB-' . $v_no . ' has been deleted successfully!');
    }
    
    public function delete($id)
    {
        // Find the transaction by ID
        $trndtl = TRNDTL::where('v_type', 'OB')
                    ->where('id', $id)
                    ->firstOrFail();

        // Delete the transaction
        $trndtl->delete();

        // Redirect back with a success message
        return redirect()->route('open_bal.reports')->with('success', 'The OB transaction has been deleted successfully!');
    }
}