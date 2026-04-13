<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\BoxBoard;
use App\Models\ItemType;
use App\Models\ItemMaster;
use App\Models\ItemLog;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
  public function index_itemmaster(Request $request)
{
    $item_code = $request->input('item_code');
    $type_id = $request->input('type_id');

    $query = ItemMaster::query();

    if ($item_code) {
        $query->where('item_code', $item_code);
    }

    if ($type_id) {
        $query->where('type_id', $type_id);
    }

    $itemmasters = $query->with('itemTypes')->get();

    // Fetch item codes and item types for dropdowns
    $items = ItemMaster::pluck('item_code', 'item_code')->unique();
    $itemTypes = ItemType::pluck('type_title', 'id')->unique();

    return view('inventory.list_item_master', get_defined_vars());
}
    public function index_itemtype()
    {
        $itemtypes = ItemType::all();
        return view('inventory.list_item_type',get_defined_vars());
    }
    public function createitemmaster()
    {
        $parties = Party::all();
        $itemtypes = ItemType::all();
        $types=['Ink','Glue'];
        return view('inventory.create_item_master',get_defined_vars());
    }
    public function createitemtype()
    {
        $itemMasters = ItemMaster::all();
        return view('inventory.create_item_type',get_defined_vars());
    }
    public function boxboard(Request $request)
    {
        BoxBoard::create([
            'name' => $request->name,
            'lenght' => $request->lenght,
            'width' => $request->width,
            'gsm' => $request->gsm,
            'no_of_packets' => $request->no_of_packets,
            'party_name' => $request->party_name,
            'gate_pass_in' => $request->gate_pass_in,
           ]);
           return redirect()->back()->with('success', 'Employee created successfully.');
    }
  public function itemmaster(Request $request)
{
    // Validate incoming request
    $request->validate([
        'item_code' => 'required|string|max:255',
        'type_id' => 'required|exists:item_types,id',
        'purchase' => 'nullable|string|max:255',
        'sale_rate' => 'nullable|numeric|min:0', // Make sale_rate optional
        'gramage' => 'required|string|max:255',
        'weight_type' => 'required|string|max:255',
    ]);

    $itemMaster = ItemMaster::create([
        'item_code' => $request->item_code,
        'type_id' => $request->type_id,
        'purchase' => $request->purchase,
        'sale_rate' => $request->filled('sale_rate') ? $request->sale_rate : null,
        'gramage' => $request->gramage,
        'weight_type' => $request->weight_type,
    ]);

    // Redirect with success message
    return redirect()->route('inventory.itemmaster.list')->with('success', 'Item created successfully.');
}


    public function itemmasteredit($id)
    {
        $itemMasters = ItemMaster::findOrFail($id);
        $itemtypes = ItemType::all(); // Get all item types for the dropdown
        return view('inventory.edit_item_master', compact('itemMasters', 'itemtypes')); // Pass both to the view
    }

 public function itemmasterupdate(Request $request, $id)
{
    // Validate incoming request
    $request->validate([
        'item_code' => 'required|string|max:255',
        'type_id' => 'required|exists:item_types,id',
        'purchase' => 'nullable|string|max:255',
        'sale_rate' => 'nullable|numeric|min:0', // Make sale_rate optional
        'gramage' => 'required|string|max:255',
    ]);

    try {
        $itemMaster = ItemMaster::findOrFail($id);
        $oldPurchase = $itemMaster->purchase;

        $itemMaster->item_code = $request->input('item_code');
        $itemMaster->type_id = $request->input('type_id');
        $itemMaster->purchase = $request->input('purchase');
        $itemMaster->sale_rate = $request->filled('sale_rate') ? $request->input('sale_rate') : null;
        $itemMaster->gramage = $request->input('gramage');
        $itemMaster->weight_type = $request->input('weight_type');
        $itemMaster->save();

        ItemLog::create([
            'item_code' => $request->item_code,
            'type_id' => $request->type_id,
            'new_purchase' => $request->purchase,
            'old_purchase' => $oldPurchase,
        ]);

    } catch (\Exception $e) {
        dd($e->getMessage());
    }

    return redirect()->route('inventory.itemmaster.list')->with('success', 'Item Master updated successfully');
}


public function itemlogList(Request $request)
{
    // Fetch all unique item_codes for the dropdown
    $items = ItemLog::distinct()->pluck('item_code');

    // Filter ItemLog records by item_code if it's selected in the dropdown
    $itemLogs = ItemLog::when($request->item_code, function ($query) use ($request) {
        return $query->where('item_code', $request->item_code);
    })->get();

    // Return the view with the itemLogs data and items for the dropdown
    return view('inventory.item_log', compact('itemLogs', 'items'));
}


    public function itemmasterdestroy($id)
    {
        $itemMasters = ItemMaster::findOrFail($id);
        $itemMasters->delete();

        return redirect()->route('inventory.itemmaster.list')->with('success', 'Item Master deleted successfully');
    }
   public function itemtype(Request $request)
{
    // Validate incoming request
    $request->validate([
        'type_title' => 'required|string|max:255|unique:item_types,type_title', // Ensure type_title is unique and within length constraints
    ]);

    // Create a new ItemType record
    ItemType::create([
        'type_title' => $request->type_title,
    ]);

    // Redirect with success message
    return redirect()->route('inventory.itemtype.list')->with('success', 'Item Type created successfully.');
}

    public function itemtypeedit($id)
    {
        $itemtypes = ItemType::findOrFail($id);
        return view('inventory.edit_item_type', get_defined_vars());
    }
  public function itemtypeupdate(Request $request, $id)
{
    // Validate incoming request
    $request->validate([
        'type_title' => [
            'required',
            'string',
            'max:255',
        ],
    ]);

    try {
        // Find the item type by ID
        $itemtypes = ItemType::findOrFail($id);

        // Update the item type
        $itemtypes->type_title = $request->input('type_title');
        $itemtypes->save();
    } catch (\Exception $e) {
        dd($e->getMessage()); // Dump the error message and stop execution
    }

    // Redirect with success message
    return redirect()->route('inventory.itemtype.list')->with('success', 'Item Type updated successfully');
}


    public function itemtypedestroy($id)
    {
        $itemtypes = ItemType::findOrFail($id);
        $itemtypes->delete();

        return redirect()->route('inventory.itemtype.list')->with('success', 'Item Type deleted successfully');
    }
}
