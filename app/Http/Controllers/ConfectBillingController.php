<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Models\ItemType;
use App\Models\TRNDTL;
use App\Models\ErpParam;
use Illuminate\Http\Request;
use App\Models\AccountMaster;
use App\Models\ConfectioneryMaster;
use Illuminate\Support\Arr;
use App\Models\ConfectBilling;
use App\Models\ProductMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ConfectBillingController extends Controller
{

    public function index()
    {
        $loggedInUser = Auth::user();
        $accounts = AccountMaster::all();
        $confect = ConfectioneryMaster::all();
        $items = ItemMaster::all();
        $saleAccounts = AccountMaster::all();
        return view('sales.confect_billing.list', compact('loggedInUser', 'accounts', 'items', 'saleAccounts', 'confect'));
    }

  public function getVnos($accountId)
    {
       // Fetch distinct voucher numbers for the given account ID (excluding NULLs)
$vnos = ConfectioneryMaster::where('account_id', $accountId)
    ->whereNotNull('v_no')  // Ensure v_no is not NULL
    ->distinct('v_no')      // Use distinct directly on v_no (MySQL/PostgreSQL)
    ->pluck('v_no')
    ->toArray();

if (empty($vnos)) {
    return response()->json(['status' => 'no_vouchers']);
}

// Fetch only the used voucher numbers (optimized query)
$existingVnos = ConfectBilling::whereIn('old_vno', $vnos)
    ->pluck('old_vno')
    ->toArray();

// Separate into available and used (faster than looping)
$usedVnos = array_values(array_intersect($vnos, $existingVnos));
$availableVnos = array_values(array_diff($vnos, $existingVnos));
$usedVnos = TRNDTL::where('account_id', $accountId)
    ->where('v_type', 'CBill')
    ->pluck('v_no')
    ->toArray();


if (!empty($usedVnos)) {
    $maxVno = max($usedVnos);
    $allVnos = range(1, $maxVno);
    $missingVnos = array_diff($allVnos, $usedVnos);

    // Combine missing + NEXT after last
    $result = array_values(array_unique(array_merge($missingVnos, [$maxVno + 1])));
} else {
    $result = [1]; // if no entries, start from 1
}


return response()->json([
    'status' => 'success',
    'vnos' => $availableVnos,
    'used_vnos' => $usedVnos,
    'cbill'=>$result
]);
    }



    public function getEntryDetails($vno)
    {
        $trndtl = ConfectioneryMaster::with(['confectioneryDetails.products', 'accounts', 'confectioneryDetails.itemType'])
            ->where('v_no', $vno)
            ->get();

        if ($trndtl->isNotEmpty()) {
            $entries = $trndtl->map(function ($data) {
                return [
                    'date' => \Carbon\Carbon::parse($data->date)->format('d-m-Y'),
                    'v_no' => $data->v_no,
                    'preparedby' => $data->preparedby,
                    'product_name' => $data->confectioneryDetails->products->prod_name ?? 'N/A',
                    'rate' => $data->confectioneryDetails->products->rate ?? 'N/A',
                    'product_id' => $data->confectioneryDetails->products->id ?? null,
                    'party' => $data->accounts->title ?? 'N/A',
                    'item_type' => $data->confectioneryDetails->itemType->type_title ?? 'N/A',
                    'item_id' => $data->confectioneryDetails->itemType->id ?? 'N/A',
                    'box' => $data->confectioneryDetails->box ?? 'N/A',
                    'pack_qty' => $data->confectioneryDetails->pack_qty ?? 'N/A',
                    'po_no' => $data->confectioneryDetails->po_no ?? 'N/A',
                    'total' => $data->confectioneryDetails->total ?? 'N/A',
                ];
            });

            return response()->json([
                'status' => 'success',
                'entries' => $entries
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No entries found for this voucher.'
            ]);
        }
    }
  

public function store(Request $request)
{
    // dd($request->all());
    $request->validate([
        'date' => 'required|date',
        'prepared_by' => 'required|string',
        'account' => 'required|integer',
        'v_type' => 'required|string',
        'total_amount' => 'required|numeric',
        'product_id' => 'required|array',
        'item_id' => 'required|array',
        'box' => 'required|array',
        'packing' => 'required|array',
        'po_no' => 'required|array',
        'total' => 'required|array',
        'grand_total' => 'required|numeric',
        'st_amount' => 'nullable|array',
    ]);
    
    $billNo = ConfectBilling::max('billing_no');
    $maxBillNo = $billNo ? ((int) $billNo + 1) : 1;

    $data = $request->all();
    $accountId = $data['account']; // Correct account_id reference

    $lastVno = ConfectBilling::where('account_id', $accountId)
    ->orderByRaw('CAST(v_no AS UNSIGNED) DESC')
    ->value('v_no');

    $vno = ($lastVno !== null) ? (int)$lastVno + 1 : 1;


    $erpParam = ErpParam::first();
    $saleAccountId = $erpParam ? $erpParam->sale_ac : null;

    // $preBal = DB::table('t_r_n_d_t_l_s') 
    //     ->select(DB::raw('IFNULL(SUM(debit), 0) - IFNULL(SUM(credit), 0) as pre_bal'))
    //     ->where('account_id', $accountId)
    //     ->value('pre_bal');
        
    $preBal = DB::table('t_r_n_d_t_l_s')
    ->select(DB::raw("
        (IFNULL(SUM(CASE WHEN account_id = {$accountId} THEN debit - credit ELSE 0 END), 0) - 
        IFNULL(SUM(CASE WHEN cash_id = {$accountId} THEN debit - credit ELSE 0 END), 0)) AS pre_bal
    "))
    ->where(function($query) use ($accountId) {
        $query->where('account_id', $accountId)
              ->orWhere('cash_id', $accountId);
    })
    ->value('pre_bal');
        
        
        

    $computedGrandTotal = 0;
    $isOfficialBill = isset($data['official_bill']) && $data['official_bill'];
    
    foreach ($data['product_id'] as $index => $productId) {
        // Fetch rate from ProductMaster for each entry
        $rateFromProduct = ProductMaster::where('id', $productId)->value('rate');
        if ($rateFromProduct === null && isset($data['item_id'][$index])) {
            $rateFromProduct = ProductMaster::where('item_id', $data['item_id'][$index])->value('rate');
        }
        $rateFromProduct = $rateFromProduct ?? 0;

        $totalUnits = (float)($data['total'][$index] ?? 0);
        
        $baseAmount = $totalUnits * (float)$rateFromProduct;
        
        $st_rate = $isOfficialBill ? 18 : 0; // Set st_rate based on checkbox
        $computedTotalRate = $baseAmount;
        if ($isOfficialBill) {
            $computedTotalRate = $baseAmount + ($baseAmount * ($st_rate/100)); // Add tax based on st_rate
        }
        
        $computedGrandTotal += $computedTotalRate;

        $saleInvoice =  ConfectBilling::create([
            'billing_no' => $maxBillNo,
              'v_no' => $request->cbill,
            'old_vno' => $data['old_vno'][$index],
            'product_name' => $productId ?? 'N/A',
            'item' => $data['item_id'][$index] ?? 'N/A',
            'box' => $data['box'][$index] ?? 'N/A',
            'packing' => $data['packing'][$index] ?? 'N/A',
            'po_no' => $data['po_no'][$index] ?? 'N/A',
            'total' => $data['total'][$index] ?? 0,
            'rate' => $rateFromProduct,
            'total_rate' => $computedTotalRate,
            'st_rate' => $st_rate, // Store the st_rate
            'st_amount' => $data['st_amount'][$index] ?? 0,
            'account_id' => $accountId,
            'v_date' => Carbon::createFromFormat('d-m-Y', $data['v_date'][$index])
                      ->format('Y-m-d'),
            'created_at' => $data['date'] ?? Carbon::now() ,
            'updated_at' =>  $data['date'] ?? Carbon::now() ,
        ]);
    }

    TRNDTL::create([
          'v_no' => $request->cbill,
        'date' => $data['date'] ?? Carbon::now() ,
        'description' => 'CBill',
        'account_id' => $accountId,
        'cash_id' => $saleAccountId,
        'preparedby' => auth()->user()->name,
        'credit' => 0,
        'debit' => $computedGrandTotal,
        'status' => 'unofficial',
        'v_type' => 'CBill',
        'r_id' => $maxBillNo,
        'pre_bal' => $preBal,
         'created_at' => $data['date'] ?? Carbon::now() ,
            'updated_at' =>  $data['date'] ?? Carbon::now() ,
    ]);

    return redirect()->route('confect_billing.reports')->with('success', 'CBill  Created Successfully: ' . $vno);
}


 public function reports(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $status = $request->input('status');
    $v_no = $request->input('v_no');
    $item = $request->input('item');
    $account_id = $request->input('account_id');
    $showPrevBalance = $request->input('show_prev_balance', '1');
    // dd($showPrevBalance);
    // Query for TRNDTL where v_type is CBill - we'll use this to filter sale invoices
    $trndtlQuery = TRNDTL::where('v_type', 'CBill')->with('accounts');
    
    // Apply date range filter if both start and end date are provided
    if ($startDate && $endDate) {
        $trndtlQuery->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Apply other filters for TRNDTL
    if ($status) {
        $trndtlQuery->where('status', $status);
    }

    if ($v_no) {
        $trndtlQuery->where('v_no', $v_no);
    }
    
    if ($account_id) {
        $trndtlQuery->where('account_id', $account_id);
    }

    // Get TRNDTL records first
    $trnDetails = $trndtlQuery->orderBy('date', 'desc')->orderBy('v_no', 'desc')      ->get();

    // Get the v_nos from the filtered TRNDTL records
    $filteredVNos = $trnDetails->pluck('v_no')->unique()->toArray();

    // Query for SaleInvoice with relationships
    $saleInvoiceQuery = ConfectBilling::with(['items', 'product', 'itemType']);

    // Apply date range filter if both start and end date are provided
    if ($startDate && $endDate) {
        $saleInvoiceQuery->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Apply other filters for SaleInvoice
    if ($v_no) {
        $saleInvoiceQuery->where('v_no', $v_no);
    }

    if ($item) {
        $saleInvoiceQuery->where('item', $item);
    }

    // Only show sale invoices that have matching TRNDTL records
    if (!empty($filteredVNos)) {
        $saleInvoiceQuery->whereIn('v_no', $filteredVNos);
    }

    // Get SaleInvoices
    $saleInvoices = $saleInvoiceQuery
    ->orderByRaw('DATE(created_at) DESC') // order by date only
    ->orderBy('v_no', 'desc')             // within same date, highest v_no first
    ->get();

    // Ensure rate and total are set for each invoice
$saleInvoices->transform(function ($invoice) {
    // If rate is missing, get from related item
    if (!isset($invoice->rate) || $invoice->rate === null) {
        $invoice->rate = $invoice->items->sale_rate ?? 0;
    }
    // If total is missing, get from related item or set to 0
    if (!isset($invoice->total) || $invoice->total === null) {
        $invoice->total = $invoice->items->purchase ?? 0;
    }
    return $invoice;
});

    // Get unique v_no values from both SaleInvoice and TRNDTL tables
    $vNoList = ConfectBilling::when(!empty($filteredVNos), function($query) use ($filteredVNos) {
            return $query->whereIn('v_no', $filteredVNos);
        })
        ->pluck('v_no')
        ->merge(TRNDTL::where('v_type', 'CBill')
            ->when($account_id, function($query) use ($account_id) {
                return $query->where('account_id', $account_id);
            })
            ->pluck('v_no'))
        ->unique()
        ->sort()
        ->values()
        ->toArray();

    // Fetch distinct item list from SaleInvoice
    $itemList = ConfectBilling::when(!empty($filteredVNos), function($query) use ($filteredVNos) {
            return $query->whereIn('v_no', $filteredVNos);
        })
        ->pluck('item')
        ->unique()
        ->toArray();
    
    $itemTitles = ItemType::whereIn('id', $itemList)
        ->pluck('type_title', 'id')
        ->toArray();

    // Fetch account list for TRNDTL and map to account titles from account_masters
    $accountList = TRNDTL::where('v_type', 'CBill')
        ->pluck('account_id')
        ->unique()
        ->toArray();
    $accountTitles = AccountMaster::whereIn('id', $accountList)
        ->pluck('title', 'id')
        ->toArray();
         // --- Calculate previous balance for each account ---
    $prevBalances = [];
    foreach ($trnDetails as $trn) {
        $accId = $trn->account_id;
        $trnDate = $trn->date;

        // Only calculate if showPrevBalance is enabled
        if ($showPrevBalance == 1) {
            $prevBalance = DB::table('t_r_n_d_t_l_s')
                ->where('account_id', $accId)
                ->where('date', '<', $trnDate)
                ->sum(DB::raw('IFNULL(debit,0) - IFNULL(credit,0)'));

            $prevBalances[$trn->id] = $prevBalance;
        } else {
            $prevBalances[$trn->id] = 0;
        }
    }

    // Attach previous balance to TRNDTL collection
    $trnDetails->transform(function($trn) use ($prevBalances) {
        $trn->pre_balance = $prevBalances[$trn->id] ?? 0;
        return $trn;
    });
    // dd($saleInvoices);

    // Return the view with all necessary data
    return view('sale_reports.index7', [
        'saleInvoices' => $saleInvoices,
        'trnDetails' => $trnDetails,
        'vNoList' => $vNoList,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'status' => $status,
        'v_no' => $v_no,
        'item' => $item,
        'itemList' => $itemTitles,
        'accountList' => $accountTitles,
        'showPrevBalance' => $showPrevBalance,
    ]);
}

public function destroy($billing_no)
{
    ConfectBilling::where('billing_no', $billing_no)->delete();

    TRNDTL::where('v_type', 'CBill')
          ->where('r_id', $billing_no)
          ->delete();

    return redirect()->back()->with('success', 'Data deleted successfully for Bill No: ' . $billing_no);
}





}