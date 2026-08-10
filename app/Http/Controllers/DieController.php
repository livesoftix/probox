<?php

namespace App\Http\Controllers;

use App\Models\DieMaster;
use App\Models\ProductMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\DieRepair;

class DieController extends Controller
{
    /**
     * Display all dies.
     */
    public function index(): View
    {
        $dies = DieMaster::with('product.items')
            ->latest()
            ->get();

        $products = ProductMaster::with('items')
            ->where('status','active')
            ->orderBy('item_id')
            ->get([
                'id',
                'item_id',
                'length',
                'width',
                'ups',
                'prod_name'
            ]);

        return view('dies.index', compact(
            'dies',
            'products'
        ));
    }

    /**
     * Get product information for AJAX.
     */
    public function product(ProductMaster $product): JsonResponse
    {
        return response()->json([
            'id' => $product->id,
            'item_name' => $product->item_name,
            'length' => $product->length,
            'width' => $product->width,
            'ups' => $product->no_of_ups,
        ]);
    }

    /**
     * Store new die.
     */
public function store(Request $request): RedirectResponse
{
    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */
// dd($request->all());
    $validated = $request->validate([
        'product_id' => [
            'required',
            'integer',
            'exists:product_master,id',
        ],

        'rate' => [
            'required',
            'numeric',
            'min:0',
        ],

        'type' => [
            'required',
            'in:new,repair,repeat',
        ],

        'repeat_date' => [
            'nullable',
            'date',
        ],

        'description' => [
            'nullable',
            'string',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | REPEAT DATE REQUIRED FOR REPEAT TYPE
    |--------------------------------------------------------------------------
    */

    if (
        $validated['type'] === 'repeat' &&
        empty($validated['repeat_date'])
    ) {
        return back()
            ->withErrors([
                'repeat_date' =>
                    'Repeat date is required for repeat type.'
            ])
            ->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | GET PRODUCT
    |--------------------------------------------------------------------------
    */
// dd($validated['product_id']);
    $product = ProductMaster::with('items')->where('id',
        $validated['product_id']
    )->first();


    /*
    |--------------------------------------------------------------------------
    | REPAIR COUNT
    |--------------------------------------------------------------------------
    |
    | New     = 0
    | Repair  = 1
    | Repeat  = 0
    |
    */

    $repairCount = 0;

    if ($validated['type'] === 'repair') {
        $repairCount = 1;
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE DIE
    |--------------------------------------------------------------------------
    */
// dd($product);
    DieMaster::create([

        'product_id' => $product->id,
        'item_id'   =>$product->item_id,

        'item_name' => $product->items?->item_code,

        'length' => $product->length,

        'width' => $product->width,

        'no_of_ups' => $product->ups,

        'rate' => $validated['rate'],

        'type' => $validated['type'],

        'repeat_date' =>
            $validated['type'] === 'repeat'
                ? $validated['repeat_date']
                : null,

        'repair_count' => $repairCount,

        'description' =>
            $validated['description'] ?? null,
    ]);


    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('dies.index')
        ->with(
            'success',
            'Die created successfully.'
        );
}

    /**
     * Update die.
     */
    public function update(Request $request,DieMaster $die): RedirectResponse {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:product_master,id',
            ],
        ]);

        $product = ProductMaster::findOrFail(
            $validated['product_id']
        );

        $die->update([
            'product_id' => $product->id,
            'item_name' => $product->item_name,
            'length' => $product->length,
            'width' => $product->width,
            'ups' => $product->no_of_ups,
        ]);

        return redirect()
            ->route('dies.index')
            ->with('success', 'Die updated successfully.');
    }

    /**
     * Delete die.
     */
    public function destroy(DieMaster $die): RedirectResponse
    {
        $die->delete();

        return redirect()
            ->route('dies.index')
            ->with('success', 'Die deleted successfully.');
    }
    public function repairData(DieMaster $die): JsonResponse
{
    return response()->json([
        'id' => $die->id,
        'item_name' => $die->item_name,
        'length' => $die->length,
        'width' => $die->width,
        'repair_count' => $die->repair_count ?? 0,
    ]);
}
public function storeRepair(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'die_id' => [
            'required',
            'integer',
            'exists:die_masters,id',
        ],

        'repair_date' => [
            'required',
            'date',
        ],

        'description' => [
            'nullable',
            'string',
            'max:2000',
        ],
    ]);


    $die = DieMaster::findOrFail(
        $validated['die_id']
    );


    /*
    |--------------------------------------------------------------------------
    | Create repair history
    |--------------------------------------------------------------------------
    */

    DieRepair::create([
        'die_id' => $die->id,

        'repair_date' =>
            $validated['repair_date'],

        'description' =>
            $validated['description'] ?? null,
    ]);


    /*
    |--------------------------------------------------------------------------
    | Increase repair count
    |--------------------------------------------------------------------------
    */

    $die->increment('repair_count');


    return redirect()
        ->route('dies.index')
        ->with(
            'success',
            'Die repair recorded successfully.'
        );
}
}