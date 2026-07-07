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
 $query = StockAdjMaster::query()->with('accounts');

        // Apply filters
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->has('v_no') && $request->v_no) {
            $query->where('v_no', $request->v_no);
        }


        if ($request->has('employee') && $request->employee) {
            $query->where('employee_type', $request->employee);
        }

        $generalJobSheets = $query->get();

        // Get only account_ids that exist in general_job_sheets
        $vNos = StockAdjMaster::distinct()->pluck('v_no');
        $accountIds = StockAdjMaster::with('accounts')
            
            ->distinct()
            ->get()
            ->pluck('account.title', 'account_id')
            ->filter();

        return view('stock-adj.index', compact('generalJobSheets', 'vNos', 'accountIds'));
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
    $validatedData = $request->validate([
        'date' => 'required|date',
        'product_type' => 'required|string',
        'item_name' => 'required|string',
        'qty' => 'required|numeric|min:0.01',
        'description' => 'nullable|string',
        'item_id' => 'nullable|numeric',

        // Purchase Boxboard
        'length' => 'nullable|numeric|required_if:product_type,Purchase Boxboard',
        'width' => 'nullable|numeric|required_if:product_type,Purchase Boxboard',

        // Purchase Plate
        'product_name' => 'nullable|string|required_if:product_type,Purchase Plate',
        'country_name' => 'nullable|string|required_if:product_type,Purchase Plate',

        // Lamination / Corrugation
        'size' => 'nullable|numeric|required_if:product_type,Lamination Purchase,Corrugation Purchase',
    ]);

    DB::beginTransaction();

    try {

        // Generate Voucher Number
        $maxVoucher = StockAdjMaster::max('v_no');
        $newVoucher = $maxVoucher ? $maxVoucher + 1 : 1;

        $stockAdj = new StockAdjMaster();

        $stockAdj->v_no = $newVoucher;
        $stockAdj->v_date = $validatedData['date'];
        $stockAdj->item_id = $validatedData['item_id'];

        $stockAdj->prepared_by = auth()->user()->id;
        $stockAdj->cid = auth()->user()->cid ?? auth()->user()->id;

        $stockAdj->product_type = $validatedData['product_type'];
        $stockAdj->item_name = $validatedData['item_name'];
        $stockAdj->qty = $validatedData['qty'];
        $stockAdj->description = $validatedData['description'] ?? null;

        switch ($validatedData['product_type']) {

            case 'Purchase Boxboard':
                $stockAdj->length = $validatedData['length'];
                $stockAdj->width = $validatedData['width'];
                break;

            case 'Purchase Plate':
                $stockAdj->product_name = $validatedData['product_name'];
                $stockAdj->country_name = $validatedData['country_name'];
                break;

            case 'Lamination Purchase':
            case 'Corrugation Purchase':
                $stockAdj->size = $validatedData['size'];
                break;
        }

        $stockAdj->save();

        DB::commit();

        return redirect()
            ->route('stock-adj.index')
            ->with('success', 'Stock Adjustment created successfully. Voucher No: ' . $newVoucher);

    } catch (\Exception $e) {

        DB::rollBack();

        return redirect()->back()
            ->withInput()
            ->with('error', 'Error creating Stock Adjustment: ' . $e->getMessage());
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
  
        try {
            // Find the StockAdjMaster by ID with account relationship
            $jobSheet = StockAdjMaster::with('accounts')->findOrFail($id);

            // Get necessary data for the form
            $loggedInUser = Auth::user();
            $accounts = AccountMaster::whereIn('level2_id', [4, 7])->get();
            $saleAccounts = AccountMaster::all();
            $items = ItemMaster::all();

            return view('stock-adj.edit', compact(
                'jobSheet',
                'loggedInUser',
                'items',
                'accounts',
                'saleAccounts'
            ));

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error loading edit form: '.$e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'prepared_by' => 'required|string',
            'account' => 'required|exists:account_masters,id',
            'product_type' => 'required|string',
            'item_name' => 'required|string',
            'qty' => 'required|numeric|min:0.01',
            'rate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'item_id' => 'nullable|numeric',

            // Conditional fields based on product type
            'length' => 'nullable|numeric|required_if:product_type,Purchase Boxboard',
            'width' => 'nullable|numeric|required_if:product_type,Purchase Boxboard',
            'product_name' => 'nullable|string|required_if:product_type,Purchase Plate',
            'country_name' => 'nullable|string|required_if:product_type,Purchase Plate',
            'size' => 'nullable|numeric|required_if:product_type,Lamination Purchase,Corrugation Purchase',
        ]);

        try {
            // Find the existing GeneralJobSheet record
            $jobSheet = StockAdjMaster::findOrFail($id);

            // Update the basic fields
            $jobsheet->item_id=$validatedData['item_id'];
            $jobSheet->prepared_by = auth()->user()->name;
            $jobSheet->product_type = $validatedData['product_type'];
            $jobSheet->item_name = $validatedData['item_name'];
            $jobSheet->qty = $validatedData['qty'];
            $jobSheet->description = $validatedData['description'] ?? null;

            // Update fields based on product type
            switch ($validatedData['product_type']) {
                case 'Purchase Boxboard':
                    $jobSheet->length = $validatedData['length'];
                    $jobSheet->width = $validatedData['width'];
                    // Clear other type-specific fields
                    $jobSheet->product_name = null;
                    $jobSheet->country_name = null;
                    $jobSheet->size = null;
                    break;

                case 'Purchase Plate':
                    $jobSheet->product_name = $validatedData['product_name'];
                    $jobSheet->country_name = $validatedData['country_name'];
                    // Clear other type-specific fields
                    $jobSheet->length = null;
                    $jobSheet->width = null;
                    $jobSheet->size = null;
                    break;

                case 'Lamination Purchase':
                case 'Corrugation Purchase':
                    $jobSheet->size = $validatedData['size'];
                    // Clear other type-specific fields
                    $jobSheet->length = null;
                    $jobSheet->width = null;
                    $jobSheet->product_name = null;
                    $jobSheet->country_name = null;
                    break;
            }

            // Save the updated record
            $jobSheet->save();

            // Return success response
            return redirect()->route('stock-adj.report')
                ->with('success', 'Stock Adjustment updated successfully.');

        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return redirect()->back()
                ->with('error', 'Error updating Stock Adjustment: '.$e->getMessage())
                ->withInput();
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
    // StockAdjDetail::where('v_no', $stockAdj->v_no)->delete();

    // Delete master
    $stockAdj->delete();
    // dd('Deleted');

    return redirect()->back()->with('success', 'Stock Adjustment deleted successfully.');
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
