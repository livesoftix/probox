<?php

namespace App\Http\Controllers;

use App\Models\DieMaster;
use App\Models\ProductMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\DieRepair;
use Illuminate\Validation\Rule;
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
        ->whereNotNull('item_id')
        ->where('status','active')
        ->orderBy('item_id')
        ->get([
            'id',
            'item_id',
            'length',
            'width',
            'ups',
            'prod_name',
        ]);

    // dd($products);

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
    // dd($request->all());
    $validated = $request->validate([
        'die_code' => [
            'required',
            'string',
            'max:100',
            'unique:die_masters,die_code',
        ],

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

        'repair_count' => [
            'nullable',
            'integer',
            'min:0',
        ],

        'description' => [
            'nullable',
            'string',
        ],
    ]);

    if ($request->type === 'repeat' && !$request->repeat_date) {
        return back()
            ->withErrors([
                'repeat_date' => 'Repeat date is required for repeat type.'
            ])
            ->withInput();
    }

    $product = ProductMaster::with('items')
    ->findOrFail($validated['product_id']);

    DieMaster::create([
        'die_code'     => $validated['die_code'],
        'product_id'   => $product->id,
        'item_id'      => $product->item_id,
        'item_name'    => $product->items?->item_code,
        'length'       => $product->length,
        'width'        => $product->width,
        'no_of_ups'    => $product->ups,
        'rate'         => $validated['rate'],
        'type'         => $validated['type'],
        'repeat_date'  => $validated['type'] === 'repeat'
                            ? $validated['repeat_date']
                            : null,
        'repair_count' => $validated['repair_count'] ?? 0,
        'description'  => $validated['description'] ?? null,
    ]);

    return redirect()
        ->route('dies.index')
        ->with('success', 'Die created successfully.');
}

public function viewData($id)
{
    $die = DieMaster::with('product.items')
        ->findOrFail($id);

    return response()->json([
        'id' => $die->id,

        'item_name' => $die->product?->items?->item_code ?? '—',

        'length' => $die->length,

        'width' => $die->width,

        'ups' => $die->no_of_ups,

        'rate' => $die->rate,

        'type' => $die->type ?? 'new',

        'repeat_date' => $die->repeat_date,

        'repair_count' => $die->repair_count ?? 0,

        'description' => $die->description,

        'repairs' => [],
    ]);
}
    /**
     * Update die.
     */
  public function update(Request $request, DieMaster $die): RedirectResponse
{
    $validated = $request->validate([
        'die_code' => [
            'required',
            'string',
            'max:100',
            Rule::unique('die_masters', 'die_code')
                ->ignore($die->id),
        ],

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

        'repair_count' => [
            'nullable',
            'integer',
            'min:0',
        ],

        'description' => [
            'nullable',
            'string',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Repeat Date Validation
    |--------------------------------------------------------------------------
    */

    if (
        $validated['type'] === 'repeat' &&
        empty($validated['repeat_date'])
    ) {
        return back()
            ->withErrors([
                'repeat_date' => 'Repeat date is required for repeat type.'
            ])
            ->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | Get Product
    |--------------------------------------------------------------------------
    */

    $product = ProductMaster::findOrFail(
        $validated['product_id']
    );

    /*
    |--------------------------------------------------------------------------
    | Update Die
    |--------------------------------------------------------------------------
    */

    $die->update([
        'die_code' => $validated['die_code'],

        'product_id' => $product->id,

        'item_id' => $product->item_name,

        'length' => $product->length,

        'width' => $product->width,

        'ups' => $product->no_of_ups,

        'rate' => $validated['rate'],

        'type' => $validated['type'],

        'repeat_date' =>
            $validated['type'] === 'repeat'
                ? $validated['repeat_date']
                : null,

        'repair_count' =>
            $validated['repair_count'] ?? 0,

        'description' =>
            $validated['description'] ?? null,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

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

        'repair_types' => [
            'nullable',
            'array',
        ],

        'repair_types.*' => [
            'string',
            'max:100',
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

        'repair_types' =>
            $validated['repair_types'] ?? [],

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
public function repairData($id)
{
    $die = DieMaster::with([
        'product.items',
        'repairs' => function ($query) {
            $query->latest('repair_date');
        }
    ])->findOrFail($id);

    return response()->json([
        'id' => $die->id,

        'item_name' => $die->product?->items?->item_code,

        'length' => $die->length,

        'width' => $die->width,

        'repair_count' => $die->repair_count ?? 0,

        'repairs' => $die->repairs->map(function ($repair) {
            return [
                'id' => $repair->id,

                'repair_date' => $repair->repair_date,

                'repair_types' => $repair->repair_types,

                'description' => $repair->description,
            ];
        })->values(),
    ]);
}

public function repeat(DieMaster $die): RedirectResponse
{
    DieMaster::create([
        'die_code'      => $die->die_code, // SAME DIE CODE
        'product_id'    => $die->product_id,
        'item_id'       => $die->item_id,
        'length'        => $die->length,
        'width'         => $die->width,
        'ups'           => $die->ups,
        'rate'          => $die->rate,

        'type'          => 'repeat',

        'repeat_date'   => now()->toDateString(),

        'repair_count'  => 0,

        'description'   => $die->description,
    ]);

    return redirect()
        ->route('dies.index')
        ->with('success', 'Die repeated successfully.');
}
}