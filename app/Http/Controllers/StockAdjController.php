<?php

namespace App\Http\Controllers;

use App\Models\TRNDTL;
use App\Models\ErpParam;
use App\Models\ItemMaster;
use App\Models\AccountMaster;
use App\Models\StockAdjDetail;
use App\Models\StockAdjMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StockAdjController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $masters = StockAdjMaster::with(['details' => function ($q) {
        $q->where('type', 'out'); // 👈 yahan apna required type likho
    }])
    ->latest()
    ->get();
        $items = ItemMaster::all();

        return view('stock-adj.index', compact('masters', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    //     $user = auth()->user();

    //     // compute next voucher number based on max existing v_no
    //     $lastVNo = StockAdjMaster::max('v_no');
    //     $nextVNo = $lastVNo ? ((int) $lastVNo + 1) : 1;

    //     // prepared_by should be the cid of the logged in user
    //     $preparedByCid = auth()->user()->name ?? null;

    //     // load items for the select (filter by company cid when available)
    //     $cid = auth()->user()->id ?? null;
    //      $items = ItemMaster::select('item_masters.*')
    // ->addSelect([
    //     'current_stock' => StockAdjDetail::select('qty')
    //         ->whereColumn('stock_adj_details.item_id', 'item_masters.id')
    //         ->orderByDesc('id')
    //         ->limit(1)
    // ])
    // ->get();
    $loggedInUser = Auth::user();
        $items = ItemMaster::all();
        $erpParams = ErpParam::with('level2')->get();

        // Initialize accountMasters as an empty collection to avoid errors
        $accountMasters = collect();
        $accountSuppliers = collect();
        $purchaseAccount = null;

        // Check if there is at least one ERP Param and that cash_level is set
        if ($erpParams->isNotEmpty()) {
            // Get the cash_level from the first ERP Param
            $cashLevelId = $erpParams->first()->cash_level;
            $supplierLevelId = $erpParams->first()->supplier_level;
            // Fetch AccountMasters associated with the cash_level
            $accountMasters = AccountMaster::where('level2_id', $cashLevelId)->get();
            $accountSuppliers = AccountMaster::where('level2_id',$supplierLevelId)->get();
            $purchaseAccountId = $erpParams->first()->purchase_account;
        $purchaseAccount = AccountMaster::find($purchaseAccountId);
        }
        return view('stock-adj.create2', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'v_no' => 'required|unique:stock_adj_masters,v_no',
    //         'v_date' => 'required|date',
    //         // prepared_by will be set server-side to the logged-in user's cid
    //         'prepared_by' => 'nullable',
    //         'details.*.item_id' => 'required|numeric',
    //         'details.*.qty' => 'required|numeric',
    //         'details.*.rate' => 'required|numeric|min:0',
    //     ]);

    //     // dd($request->all());

    //     DB::transaction(function () use ($request) {
    //         $master = StockAdjMaster::create([
    //             'v_no' => $request->v_no,
    //             'v_date' => $request->v_date,
    //             // ensure prepared_by stores the cid of the logged-in user
    //             'prepared_by' => auth()->user()->id ?? $request->prepared_by,
    //             'cid' => auth()->user()->id ?? null,
    //         ]);

    //         foreach ($request->details as $detail) {
    //             $master->details()->create(array_merge($detail, [
    //                 'cid' => auth()->user()->id, 'v_date' => $request->v_date,
    //             ]));
    //         }
    //     });

    //     return redirect()->route('stock-adj.index')->with('success', 'Stock Adjustment saved successfully!');
    // }

    public function store(Request $request)
{
    // dd($request->all());
    $request->validate([
    'entries' => 'required|array',
    'entries.*.item' => 'required|numeric',
    'entries.*.quantity' => 'required|numeric',
    'entries.*.rate' => 'required|numeric|min:0',
]);
    $lastInvoiceNumber = StockAdjDetail::where('type', 'Out')
        ->max('v_no');


    // If no records found, start from 0
    $lastInvoiceNumber = $lastInvoiceNumber ?? 0;
    // dd($lastInvoiceNumber);

    // Increment voucher number
    $newInvoiceNumber = $lastInvoiceNumber + 1;
    // dd($newInvoiceNumber);
    
DB::transaction(function () use ($request, $newInvoiceNumber) {
$date = collect($request->entries)->first()['date'];
// dd($request->entries);
        // 1. MASTER ENTRY
        $master = StockAdjMaster::create([
            'v_no' => $newInvoiceNumber,
            'v_date' => $date,
            'prepared_by' => auth()->user()->id,
            'cid' => auth()->user()->cid ?? auth()->user()->id,
        ]);

        // 2. DETAILS ENTRY (same style as PurchaseDetail loop)
        foreach ($request->entries as $detail) {
// dd($detail);
            $itemCode = DB::table('item_masters')
                ->where('id', $detail['item'])
                ->value('item_code');

            $master->details()->create([
                'account_id' => $detail['supplier'] ?? null,
                'item_id'   => $detail['item'],
                'item_code' => $itemCode,
                'qty'   => $detail['quantity'] ?? 0,
                'rate'  => $detail['rate'] ?? 0,
                'width' => $detail['width'] ?? 0,
                'length'=> $detail['length'] ?? 0,
                'grammage'=> $detail['gramage'] ?? 0,
                'amount'=> $detail['rate']* $detail['weight'] ?? 0,

                'total_wt' => $detail['weight'] ?? 0,
                'freight'  => $detail['freight'] ?? 0,

                'v_date' => $date,
                'type' => 'Out',
                'cid'    => auth()->user()->cid ?? auth()->user()->id,
            ]);
        }
    });

    return redirect()
        ->route('stock-adj.index')
        ->with('success', 'Stock Adjustment saved successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stock_adj = StockAdjMaster::with(['details.item', 'preparedByUser'])->findOrFail($id);

        return view('stock-adj.show', compact('stock_adj'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(StockAdjMaster $stock_adj)
    // {
    //     $user = auth()->user();

    //     $stock_adj->load('details');
    //     // $items = ItemMaster::all();
    //    $items = ItemMaster::select('item_masters.*')
    // ->addSelect([
    //     'current_stock' => StockAdjDetail::select('qty')
    //         ->whereColumn('stock_adj_details.item_id', 'item_masters.id')
    //         ->orderByDesc('id')
    //         ->limit(1)
    // ])
    // ->get();

    //     return view('stock-adj.edit', compact('stock_adj', 'items'));
    // }

    public function edit($v_no)
{
    // dd($v_no);
    $loggedInUser = Auth::user();
    $voucher = StockAdjMaster::with([
    'details',
    'details.accounts',
    'details.item'
])->where('v_no', $v_no)
                ->get();
                // dd($voucher);
                
    $erpParams = ErpParam::with('level2')->get();
    $accountMasters = collect(); 
    $accountSuppliers = collect();
    $purchaseAccount = null;

    if ($erpParams->isNotEmpty()) {
        $cashLevelId = $erpParams->first()->cash_level;
        $supplierLevelId = $erpParams->first()->supplier_level;
        $accountMasters = AccountMaster::where('level2_id', $cashLevelId)->get();
        $accountSuppliers = AccountMaster::all();
        $purchaseAccountId = $erpParams->first()->purchase_account;
        $purchaseAccount = AccountMaster::find($purchaseAccountId);
    }

    $items = ItemMaster::all();
    // dd($voucher->first()->v_no);


    // Pass v_no explicitly to the view
    return view('stock-adj.edit2', compact('v_no', 'loggedInUser', 'voucher', 'erpParams', 'accountMasters', 'accountSuppliers', 'purchaseAccount', 'items'));
}

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    // dd($request->all());
    $request->validate([
        // 'v_date' => 'required|date',
        'entries' => 'required|array',
        'entries.*.item' => 'required|numeric',
        'entries.*.quantity' => 'required|numeric',
        'entries.*.rate' => 'required|numeric|min:0',
    ]);
    // dd("sdn");

    DB::beginTransaction();

    try {

        // 1. Get Master
        $master = StockAdjMaster::where('v_no', $id)->firstOrFail();
        $date = collect($request->entries)->first()['date'];
        // 2. Update Master only
        $master->update([
            'v_date' => $date,
            'prepared_by' => auth()->user()->id,
            'cid' => auth()->user()->cid ?? auth()->user()->id,
        ]);

        // 3. Delete old details (important ERP pattern)
        // $master->details()->delete();

        // 4. Re-insert details (same as store)
        foreach ($request->entries as $entry) {
// dd($entry);
            $itemCode = DB::table('item_masters')
                ->where('id', $entry['item'])
                ->value('item_code');

            $qty = $entry['quantity'] ?? 0;
            $rate = $entry['rate'] ?? 0;

            $master->details()->create([
                'item_id'   => $entry['item'],
                'item_code' => $itemCode,
                'account_id' => $entry['supplier'] ?? null,

                'qty'   => $qty,
                'rate'  => $rate,
                'amount'=> $qty * $rate,

                'width'    => $entry['width'] ?? 0,
                'length'   => $entry['length'] ?? 0,
                'grammage' => $entry['gramage'] ?? 0,

                'total_wt' => $entry['weight'] ?? 0,
                'freight'  => $entry['freight'] ?? 0,

                'v_date' => $date,
                'type'   => 'Out', // 🔴 Stock reduction
                'cid'    => auth()->user()->cid ?? auth()->user()->id,
            ]);
        }

        DB::commit();

        return redirect()
            ->route('stock-adj.index')
            ->with('success', 'Stock Adjustment updated successfully!');

    } catch (\Exception $e) {

        DB::rollBack();

        \Log::error('Stock Adj Update Error: ' . $e->getMessage());

        return redirect()
            ->back()
            ->withErrors(['error' => 'Something went wrong while updating stock adjustment.']);
    }
}
    public function report(){
          $user = auth()->user();

        $masters = StockAdjMaster::with('details')->latest()->get();
        $items = ItemMaster::all();
       
        return view('report_stock.index2', compact('masters', 'items'));
    }

    /**
     * Remove the specified resource from storage.
     */
 public function destroy($id)
{
    // Find master record (voucher)
    $stockAdj = StockAdjMaster::find($id);

    if (!$stockAdj) {
        return redirect()->back()->with('error', 'Record not found.');
    }

    // Delete all related details using v_no
    StockAdjDetail::where('v_no', $stockAdj->v_no)->delete();

    // Delete master
    $stockAdj->delete();
    dd('Deleted');

    return redirect()->back()->with('success', 'Stock Adjustment deleted successfully.');
}
public function destroyDetail($id)
{
    StockAdjDetail::where('id', $id)->delete();

    return back()->with('success', 'Row deleted successfully!');
}
}
