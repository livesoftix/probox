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
   public function index(Request $request)
{
    $query = StockAdjDetail::with('master');

    if ($request->start_date) {
        $query->whereDate('v_date','>=',$request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('v_date','<=',$request->end_date);
    }

    if ($request->v_no) {
        $query->where('v_no',$request->v_no);
    }

    if ($request->product_type) {
        $query->where('product_type',$request->product_type);
    }

    $adjustments = $query
        ->orderBy('v_no','desc')
        ->get();
// dd($adjustments);
    $vNos = StockAdjMaster::orderBy('v_no','desc')
                ->pluck('v_no');

    return view(
        'stock-adj.index',
        compact('adjustments','vNos')
    );
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
   $loggedInUser = Auth::user();
        $accounts = AccountMaster::whereIn('level2_id', [4, 7])->get();
        $saleAccounts = AccountMaster::all();
        $items = ItemMaster::all();

        return view('stock-adj.create', compact('loggedInUser', 'items', 'accounts', 'saleAccounts'));
        
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
        'date' => 'required|date',

        'product_type' => 'required|array',
        'product_type.*' => 'required|string',

        'item_name' => 'required|array',
        'item_name.*' => 'required|string',

        'item_id' => 'required|array',
        'item_id.*' => 'required',

        'qty' => 'required|array',
        'qty.*' => 'required|numeric|min:0.01',

        'adjustment_type' => 'required|array',
        'adjustment_type.*' => 'required|in:IN,OUT',
    ]);

    DB::beginTransaction();

    try {

        // Generate Voucher Number
        $maxVoucher = StockAdjMaster::max('v_no');
        $newVoucher = $maxVoucher ? $maxVoucher + 1 : 1;

        // Master
        StockAdjMaster::create([
            'v_no'        => $newVoucher,
            'v_date'      => $request->date,
            'prepared_by' => auth()->id(),
            'cid'         => auth()->user()->cid ?? auth()->id(),
        ]);

        // Details
        foreach ($request->item_id as $key => $itemId) {

            StockAdjDetail::create([

                'v_no' => $newVoucher,

                'v_date' => $request->date,

                'cid' => auth()->user()->cid ?? auth()->id(),

                'item_id' => $itemId,

                'product_type' => $request->product_type[$key],

                'item_name' => $request->item_name[$key],

                'qty' => $request->qty[$key],

                'adjustment_type' => $request->adjustment_type[$key],

                'description' => $request->description[$key] ?? null,

                'length' => $request->length[$key] ?? null,

                'width' => $request->width[$key] ?? null,

                'product_name' => $request->product_name[$key] ?? null,

                'country_name' => $request->country_name[$key] ?? null,

                'size' => $request->size[$key] ?? null,

            ]);
        }

        DB::commit();

        return redirect()
            ->route('stock-adj.index')
            ->with('success', 'Stock Adjustment created successfully. Voucher No: '.$newVoucher);

    } catch (\Exception $e) {

        DB::rollBack();

        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stock_adj = StockAdjMaster::with(['details.item', 'preparedByUser'])->findOrFail($id);

        return view('stock-adj.show', compact('stock_adj'));
    }

   
public function edit($id)
{
    $detail = StockAdjDetail::findOrFail($id);

    $master = StockAdjMaster::with('details')
                ->where('v_no', $detail->v_no)
                ->firstOrFail();

    $loggedInUser = auth()->user();

    return view('stock-adj.edit', compact(
        'master',
        'loggedInUser',
        'detail'
    ));
}

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request,$id)
{
    // dd($request->all());
    DB::beginTransaction();

    try{

        $master = StockAdjMaster::findOrFail($id);

        $master->update([
            'v_date'=>$request->date
        ]);

        StockAdjDetail::where('v_no',$master->v_no)->delete();

        foreach($request->item_id as $key=>$item){

            StockAdjDetail::create([

                'v_no'=>$master->v_no,

                'v_date'=>$request->date,

                'cid'=>auth()->user()->cid ?? auth()->id(),

                'item_id'=>$item,

                'product_type'=>$request->product_type[$key],

                'item_name'=>$request->item_name[$key],

                'qty'=>$request->qty[$key],

                'adjustment_type'=>$request->adjustment_type[$key],

                'description'=>$request->description[$key] ?? null,

                'length'=>$request->length[$key] ?? null,

                'width'=>$request->width[$key] ?? null,

                'product_name'=>$request->product_name[$key] ?? null,

                'country_name'=>$request->country_name[$key] ?? null,

                'size'=>$request->size[$key] ?? null,

            ]);

        }

        DB::commit();

        return redirect()
            ->route('stock-adj.index')
            ->with('success','Updated Successfully');

    }catch(\Exception $e){

        DB::rollBack();

        return back()->withInput()->with('error',$e->getMessage());

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
    DB::beginTransaction();

    try {

        $detail = StockAdjDetail::findOrFail($id);

        $vNo = $detail->v_no;

        // Delete selected detail
        $detail->delete();

        // Delete master if no details remain
        if (!StockAdjDetail::where('v_no', $vNo)->exists()) {
            StockAdjMaster::where('v_no', $vNo)->delete();
        }

        DB::commit();

        return back()->with('success', 'Deleted Successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
public function destroyDetail($id)
{
    StockAdjDetail::where('id', $id)->delete();

    return back()->with('success', 'Row deleted successfully!');
}

public function getUpdatedStock(Request $request)
{
    try {

        $request->validate([
            'purchase_type' => 'required|string',
            'item_id'       => 'required|string',
        ]);

        $viewMap = [
            'Purchase Boxboard'      => ['view' => 'boxboard_view',     'column' => 'item_code'],
            'Purchase Plate'         => ['view' => 'plate_view',        'column' => 'item_code'],
            'Glue Purchase'          => ['view' => 'glue_view',         'column' => 'item'],
            'Ink Purchase'           => ['view' => 'ink_view',          'column' => 'item'],
            'Lamination Purchase'    => ['view' => 'lamination_view',   'column' => 'item_name'],
            'Corrugation Purchase'   => ['view' => 'corrugation_view',  'column' => 'item_name'],
            'Shipper Purchase'       => ['view' => 'shipper_view',      'column' => 'item'],
            'Dye Purchase'           => ['view' => 'dye_view',          'column' => 'item_name'],
        ];

        if (!isset($viewMap[$request->purchase_type])) {
            return response()->json([
                'error' => 'Invalid purchase type.'
            ], 422);
        }

        $config = $viewMap[$request->purchase_type];

        $item = DB::table($config['view'])
            ->where($config['column'], $request->item_id)
            ->first();

        if (!$item) {
            return response()->json([
                'error' => 'Item not found.'
            ], 404);
        }

        return response()->json([
            'remain_qty'   => $item->remain_qty,
            'length'       => $item->length ?? null,
            'width'        => $item->width ?? null,
            'size'         => $item->size ?? null,
            'product_name' => $item->product_name ?? null,
            'country_name' => $item->country_name ?? null,
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage()
        ], 500);

    }
}

  public function getPurchaseItems(Request $request)
    {
        try {
            $request->validate([
                'purchase_type' => 'required',
                'view' => 'required',
                'item_column' => 'required',
            ]);

            $query = DB::table($request->view);

            // For Boxboard, include all necessary fields
            if ($request->purchase_type === 'Purchase Boxboard') {
                $items = $query->select([
                    'item_id',
                    'item_code',
                    'length',
                    'width',
                    'remain_qty',
                ])->get();
            }
            // For Lamination and Corrugation, include size
            elseif ($request->purchase_type === 'Lamination Purchase' || $request->purchase_type === 'Corrugation Purchase') {
                $items = $query->select([
                    'item_id',
                    $request->item_column,
                    'remain_qty',
                    'size',
                ])->get();
            } else {
                // For other types, include at least remain_qty
                $items = $query->select([
                    DB::raw('item_code as item_id'),
                    $request->item_column,
                    'remain_qty',
                ])->get();
            }

            return response()->json($items);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: '.$e->getMessage()], 500);
        }
    }
}
