<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TempJobSheet;
use App\Models\ProductMaster;
use App\Models\ItemMaster;

class TempJobSheetController extends Controller
{
    /* -------------------------
        INDEX
    ------------------------- */
    public function index()
    {
        $loggedInUser = Auth::user();
        $jobs = TempJobSheet::orderBy('id', 'desc')->get();

        return view('temp_job_sheet.index', compact('jobs', 'loggedInUser'));
    }

    /* -------------------------
        REPORT
    ------------------------- */
   public function report(Request $request)
{
    $query = TempJobSheet::query()->with(['account','product']);

    // DATE FILTER (use actual job sheet date, not created_at)
    if ($request->start_date) {
        $query->whereDate('date', '>=', $request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('date', '<=', $request->end_date);
    }

    // V NO FILTER
    if ($request->v_no) {
        $query->where('v_no', $request->v_no);
    }

    // ACCOUNT FILTER
    if ($request->account_id) {
        $query->where('account_id', $request->account_id);
    }
    if($request->job_id){
          $query->whereHas('product', function ($q) use ($request) {
            $q->where('id', '>=', $request->job_id);
        });
    }

    // ❌ REMOVE THIS (column doesn't exist)
    // if ($request->employee) {
    //     $query->where('employee_type', $request->employee);
    // }

    $generalJobSheets = $query->orderBy('id', 'desc')->get();
      $products= ProductMaster::all();

    // dropdown data
    $vNos = TempJobSheet::distinct()->pluck('v_no');

    $accountIds = TempJobSheet::with(['account','product'])
        ->whereNotNull('account_id')
        ->get()
        ->pluck('account.title', 'account_id')
        ->filter();

    return view('temp_job_sheet.index', compact(
        'generalJobSheets',
        'vNos',
        'accountIds',
        'products'

    ));
}


    /* -------------------------
        CREATE
    ------------------------- */
    public function create()
    {
        $loggedInUser = Auth::user();

        $jobNo = (TempJobSheet::max('id') ?? 0) + 1;
        $products= ProductMaster::all();
        $items = ItemMaster::all(); 
        // dd($products->first());

        // $boxboardData = DB::table('boxboard_views as b')
        //     ->select(
        //         'b.item_id',
        //         'i.item_code',
        //         'b.width',
        //         'b.lenght as length',
        //         'b.remain_qty'
        //     )
        //     ->join('item_masters as i', 'b.item_id', '=', 'i.id')
        //     ->get();

        $boxboardData = DB::table('boxboard_views as b')
    ->select(
        'b.v_no',
        'b.item_id',
        'i.item_code',
        'b.width',
        'b.lenght as length',
        'b.remain_qty'
    )
    ->join('item_masters as i', 'b.item_id', '=', 'i.id')
    ->get();


        return view('temp_job_sheet.list', compact(
            'loggedInUser',
            'jobNo',
            'boxboardData',
            'products','items'
        ));
    }

    /* -------------------------
        STORE
    ------------------------- */
   public function store(Request $request)
{
    $validated = $request->validate([
        'date' => 'nullable|date',
        'job_no' => 'nullable|string',
        'preparedby' => 'nullable|string',
        'printing_for' => 'nullable|string',
        'job_id' => 'nullable|numeric',
        'size' => 'nullable|string',
        'qty' => 'nullable|numeric',

        'p_size' => 'nullable|string',
        'ream_pkt' => 'nullable|string',

        'note' => 'nullable|string',
        'm_date' => 'nullable|date',
        'e_date' => 'nullable|date',

        'box_item' => 'nullable|array',
        'box_qty' => 'nullable|array',
        'box_length' => 'nullable|array',
        'box_width' => 'nullable|array',
        'ups'      =>'nullable|numeric',
          // Process Details
    'lamination' => 'nullable|boolean',
    'lsize' => 'nullable|numeric',
    'litem' => 'nullable|integer',

    'corrugation' => 'nullable|boolean',
    'csize' => 'nullable|numeric',
    'citem' => 'nullable|integer',

    'color' => 'nullable|numeric',
    'noColor' => 'nullable|boolean',

    'window' => 'nullable|boolean',
    'glass_win' => 'nullable|boolean',

    'uv' => 'nullable|boolean',
    'simple' => 'nullable|boolean',
    'spot' => 'nullable|boolean',
    'tripof' => 'nullable|boolean',

    'varnish' => 'nullable|boolean',

    'emboss' => 'nullable|boolean',
    'emboss_rate' => 'nullable|numeric',

    'breaking' => 'nullable|boolean',
    ]);

    try {

        DB::beginTransaction();

        $job = new TempJobSheet();

        $job->date = $validated['date'] ?? now();
        $job->printing_for=$validated['printing_for'] ?? null;
        $job->preparedby=$validated['preparedby'] ?? null;

        // temp_job_sheets table uses v_no
        $job->v_no = $validated['job_no']
            ?? ((TempJobSheet::max('id') ?? 0) + 1);

        $job->job_id = $validated['job_id'] ?? null;
        $job->size = $validated['size'] ?? null;
        $job->qty = $validated['qty'] ?? 0;

        $job->p_size = $validated['p_size'] ?? null;
        $job->ream_packet = $validated['ream_pkt'] ?? null;

        /* ==========================
   PROCESS DETAILS
========================== */

$job->lamination = $validated['lamination'] ?? 0;
$job->lam_size   = $validated['lsize'] ?? null;
$job->lam_item   = $validated['litem'] ?? null;

$job->corrugation = $validated['corrugation'] ?? 0;
$job->curr_size   = $validated['csize'] ?? null;
$job->curr_item   = $validated['citem'] ?? null;

$job->color    = $validated['noColor'] ?? 0;
$job->color_no = $validated['color'] ?? null;

$job->window    = $validated['window'] ?? 0;
$job->glass_win = $validated['glass_win'] ?? 0;

$job->uv     = $request->has('uv');
$job->simple = $request->has('simple');
$job->spot   = $request->has('spot');
$job->tripof = $request->has('tripof');

$job->varnish = $validated['varnish'] ?? 0;

$job->emboss = $validated['emboss'] ?? 0;

// if column exists
// $job->emboss_rate = $validated['emboss_rate'] ?? null;

$job->breaking = $validated['breaking'] ?? 0;

       
        $job->note = $validated['note'] ?? null;
        $job->m_date = $validated['m_date'] ?? null;
        $job->e_date = $validated['e_date'] ?? null;
        $job->ups  = $validated['ups']  ?? 0;

        $job->created_by = Auth::id();

        $job->save();

        /* ==========================
           SAVE BOXBOARD ITEMS
        ========================== */
        if (!empty($request->box_item)) {

            foreach ($request->box_item as $key => $itemId) {

                $qty = $request->box_qty[$key] ?? 0;
                $length = $request->box_length[$key] ?? null;
                $width = $request->box_width[$key] ?? null;
                $pvno=$request->purchase_vno[$key] ?? null;

                // dd($pvno);
                if (!empty($itemId) && $qty > 0) {

                    // item value comes like: 5_20_30
                    $parts = explode('_', $itemId);

                    DB::table('temp_job_sheet_boxboard')->insert([
                        'job_sheet_id' => $job->id,
                        'item_id' => $parts[1] ?? $itemId,
                        'purchase_v_no' =>$pvno,
                        'length' => $length,
                        'width' => $width,
                        'qty' => $qty,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        DB::commit();

        return redirect()
            ->route('tempjob.index')
            ->with('success', 'Job Sheet created successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        dd([
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);
    }
}

    /* -------------------------
        EDIT
    ------------------------- */
    public function edit($id)
    {
        $job = TempJobSheet::findOrFail($id);
        $loggedInUser = Auth::user();

        return view('temp_job_sheet.edit', compact('job', 'loggedInUser'));
    }

    /* -------------------------
        UPDATE
    ------------------------- */
    public function update(Request $request, $id)
    {
        $job = TempJobSheet::findOrFail($id);

        $job->update($request->all());

        return redirect()
            ->route('tempjob.index')
            ->with('success', 'Updated successfully');
    }

    /* -------------------------
        DELETE
    ------------------------- */
    public function destroy($id)
    {
        TempJobSheet::findOrFail($id)->delete();

        return back()->with('success', 'Deleted successfully');
    }

    /* -------------------------
        PRINT
    ------------------------- */
   public function print($id)
{
    $job = TempJobSheet::with([
        'product',
        'boxboards.item',
        'lamItem',
        'currItem'
    ])->findOrFail($id);

    $stockMap = DB::table('boxboard_views')
    ->get()
    ->groupBy(function ($item) {
        return $item->v_no.'_'.$item->item_id.'_'.$item->lenght.'_'.$item->width;
    });

    foreach ($job->boxboards as $box) {

        // $key = $box->item_id.'_'.$box->length.'_'.$box->width;
        $key = $box->purchase_v_no.'_'.$box->item_id.'_'.$box->length.'_'.$box->width;

        $view = $stockMap[$key][0] ?? null;

        $box->t_stock = $view->p_qty ?? 0;
        $box->remain_stock = $view->remain_qty ?? 0;
    }

    return view('temp_job_sheet.print', compact('job'));
}
    /* -------------------------
        BOXBOARD API
    ------------------------- */
    public function getboxboard()
    {
        return DB::table('boxboard_views as b')
            ->select(
                'b.item_id',
                'i.item_code',
                'b.width',
                'b.lenght as length',
                'b.remain_qty'
            )
            ->join('item_masters as i', 'b.item_id', '=', 'i.id')
            ->get();
    }
   public function getProductDetails($id)
{
    $product = ProductMaster::with('items')->find($id);
    // dd($product);

    return response()->json([
        'length' => $product->length ?? 0,
        'width'  => $product->width ?? 0,
        'ups'    =>$product->ups  ?? 0,
        'item_id'   =>$product->item_id ?? 0,
        'item'     =>$product->items?->item_code,

         // Lamination
    'lamination' => $product->lamination,
    'lam_size' => $product->lam_size,
    'lam_item' => $product->lam_item,

    // UV
    'uv' => $product->uv,
    'simple' => $product->simple,
    'spot' => $product->spot,
    'tripof' => $product->tripof,

    // Corrugation
    'corrugation' => $product->corrugation,
    'curr_size' => $product->curr_size,
    'curr_item' => $product->curr_item,

    // Color
    'color' => $product->color,
    'color_no' => $product->color_no,

    // Window
    'window' => $product->window,
    'glass_win' => $product->glass_win,
    'lam_win' => $product->lam_win,

    // Others
    'varnish' => $product->varnish,
    'emboss' => $product->emboss,
    'breaking' => $product->breaking,

    ]);
}
    
}