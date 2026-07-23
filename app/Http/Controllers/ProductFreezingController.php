<?php
namespace App\Http\Controllers;
use App\Models\ProductFreezing;
use App\Models\ProductMaster;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductFreezingController extends Controller
{
   public function index(Request $request)
{
    $products = ProductMaster::orderBy('id')->get();

    $query = ProductFreezing::with('product');

    if ($request->filled('date')) {
        $query->whereDate('date', $request->date);
    }

    if ($request->filled('product_id')) {
        $query->where('product_id', $request->product_id);
    }

    $records = $query->latest()->get();

    return view('product_freezing.index', compact('records', 'products'));
}

  public function create()
{
    $products = ProductMaster::where('status','Active')
                    ->orderBy('id')
                    ->get();

    $lastId = ProductFreezing::max('id') + 1;

    $slipNo = 'PF-' . str_pad($lastId,5,'0',STR_PAD_LEFT);
    // dd($products);

    return view('product_freezing.create',compact(
        'products',
        'slipNo'
    ));
}

    public function store(Request $request)
{
    $request->validate([
        'date'=>'required',
        'product_id'=>'required',
        'description'=>'nullable'
    ]);

    ProductFreezing::create([
        'date'=>$request->date,
        'slip_no'=>$request->slip_no,
        'product_id'=>$request->product_id,
        'description'=>$request->description,
    ]);

    ProductMaster::where('id',$request->product_id)
        ->update([
            'status'=>'Inactive'
        ]);

    return redirect()
        ->route('product-freezing.index')
        ->with('success','Product freezed successfully.');
}

  public function show($id)
{
    $productFreezing = ProductFreezing::with('product')->findOrFail($id);

    return view(
        'product_freezing.show',
        compact('productFreezing')
    );
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

  public function update(Request $request,$id)
{
    $request->validate([
        'date' => 'required',
        'product_id' => 'required',
        'description' => 'nullable'
    ]);

    $freezing = ProductFreezing::findOrFail($id);

    $freezing->update([
        'date' => $request->date,
        'product_id' => $request->product_id,
        'description' => $request->description,
    ]);

    ProductMaster::where('id', $freezing->product_id)
        ->update([
            'status' => $request->status
        ]);

    return redirect()
        ->route('product-freezing.index')
        ->with('success', 'Product Freezing Updated Successfully.');
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