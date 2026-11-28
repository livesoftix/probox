<?php
namespace App\Http\Controllers;
use App\Models\ProductFreezing;
use App\Models\ProductMaster;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductFreezingController extends Controller
{
public function index(Request $request)
{
    $query = ProductFreezing::with('product');

    if ($request->filled('product_id')) {
        $query->where('product_id', $request->product_id);
    }

    if ($request->filled('start_date')) {
        $query->whereDate('date', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('date', '<=', $request->end_date);
    }

    if ($request->filled('status')) {
        $query->whereHas('product', function ($q) use ($request) {
            $q->where('status', $request->status);
        });
    }

    $records = $query->latest()->get();

    $products = ProductMaster::where('status','active')->get();
    // dd($products);

    return view('product_freezing.index', compact(
        'records',
        'products'
    ));
}

  public function create()
{
    $products = ProductMaster::where('status','active')
                    ->orderBy('id')
                    ->get();

    $lastId = ProductFreezing::max('id') + 1;

    // $slipNo = 'PF-' . str_pad($lastId,5,'0',STR_PAD_LEFT);
    // dd($products);

    return view('product_freezing.create',compact(
        'products',
        'slipNo'
    ));
}
public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'slip_no' => 'required|string',
        'product_ids' => 'required|array|min:1',
        'product_ids.*' => 'required|exists:product_master,id',
        'description' => 'nullable|string',
        'prepared_by' => 'nullable|string|max:255',
        'production_by' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    $imagePath = null;

    // Upload image if provided
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('product_freezing', 'public');
    }

    DB::transaction(function () use ($request, $imagePath) {

        foreach ($request->product_ids as $productId) {

            ProductFreezing::create([
                'date' => $request->date,
                'slip_no' => $request->slip_no,
                'product_id' => $productId,
                'description' => $request->description,
                'prepared_by' => $request->prepared_by,
                'production_by' => $request->production_by,
                'image' => $imagePath,
            ]);

            ProductMaster::where('id', $productId)
                ->update([
                    'status' => 'Inactive'
                ]);
        }

    });

    return redirect()
        ->route('product-freezing.index')
        ->with('success', 'Product freezing slip saved successfully.');
}

public function show($id)
{
    $productFreezing = ProductFreezing::with('product')->findOrFail($id);

    $products = ProductMaster::orderBy('prod_name')->get();

    return view('product_freezing.show', compact(
        'productFreezing',
        'products'
    ));
}

    public function edit($id)
{
    $productFreezing = ProductFreezing::findOrFail($id);

    $products = ProductMaster::orderBy('id')->get();

    return view(
        'product_freezing.edit',
        compact(
            'productFreezing',
            'products'
        )
    );
}


public function update(Request $request, $id)
{
    $row = ProductFreezing::findOrFail($id);

    $request->validate([
        'date'          => 'required|date',
        'product_id'    => 'required|exists:product_masters,id',
        'status'        => 'required|in:Active,Inactive,active,inactive',
        'description'   => 'nullable|string',
        'prepared_by'   => 'nullable|string|max:255',
        'production_by'  => 'nullable|string|max:255',
        'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
    ]);

    $oldProductId = $row->product_id;
    $newProductId = $request->product_id;

    $oldImagePath = $row->image;
    $newImagePath = $oldImagePath;

    // Upload replacement image if selected
    if ($request->hasFile('image')) {
        $newImagePath = $request->file('image')
            ->store('product_freezing', 'public');
    }

    \DB::beginTransaction();

    try {

        // Update freezing slip
        $row->update([
            'date'         => $request->date,
            'product_id'   => $newProductId,
            'description'  => $request->description,
            'prepared_by'  => $request->input('prepared_by', $row->prepared_by),
            'production_by' => $request->input('production_by', $row->production_by),
            'image'        => $newImagePath,
        ]);

        // If product changed, restore old product status
        if ($oldProductId != $newProductId) {
            ProductMaster::where('id', $oldProductId)
                ->update(['status' => 'Active']);
        }

        // Update selected product status
        ProductMaster::where('id', $newProductId)
            ->update([
                'status' => ucfirst(strtolower($request->status))
            ]);

        \DB::commit();

        // Delete previous image after successful update
        if ($request->hasFile('image') && $oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()
            ->route('product-freezing.index')
            ->with('success', 'Product Freezing Slip updated successfully.');

    } catch (\Exception $e) {

        \DB::rollBack();

        // Delete newly uploaded image if update failed
        if ($request->hasFile('image') && $newImagePath && $newImagePath != $oldImagePath) {
            Storage::disk('public')->delete($newImagePath);
        }

        return back()
            ->withInput()
            ->with('error', 'Failed to update Product Freezing Slip: ' . $e->getMessage());
    }
}
    public function destroy($id)
{
    $productFreezing = ProductFreezing::findOrFail($id);

    // Optional: make the product active again when deleting the freezing record
    ProductMaster::where('id', $productFreezing->product_id)
        ->update([
            'status' => 'Active'
        ]);

    $productFreezing->delete();

    return redirect()
        ->route('product-freezing.index')
        ->with('success', 'Product Freezing deleted successfully.');
}
    public function print($id)
{
    $productFreezing = ProductFreezing::with('product')->findOrFail($id);

    return view('product_freezing.print', compact('productFreezing'));
}
}