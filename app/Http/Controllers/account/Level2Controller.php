<?php

namespace App\Http\Controllers\account;

use App\Models\Level1;
use App\Models\Level2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Models\AccountMaster;

class Level2Controller extends Controller
{
    public function index()
    {
        $level2s = Level2::with('level1s')->get();
        return view('accounts.level2.list',get_defined_vars());
    }
    public function create()
    {
        $level1s = Level1::all();
        return view('accounts.level2.create',get_defined_vars());
    }
   public function store(Request $request)
{
    // Validation rules
    $request->validate([
        'title' => 'required|string|max:255',
        'level1_id' => 'required|exists:level1s,id',  // Ensure a valid level1 is selected
    ]);
    $lastLevel = Level2::where('level1_id', $request->level1_id)
    ->orderBy('id', 'desc')
    ->first();

// If no previous record exists, start from '001'. Otherwise, increment the last code.
$newCode = $lastLevel ? str_pad((int)$lastLevel->level2_code + 1, 3, '0', STR_PAD_LEFT) : '001';

// Ensure that the code is generated
if ($newCode === null) {
return back()->withErrors(['level1_code' => 'Failed to generate a valid level1_code']);
}

    // Store Level2
    Level2::create([
        'title' => $request->title,
        'level1_id' => $request->level1_id,
        'level2_code' => $newCode
    ]);

    // Redirect with success message
    return redirect()->route('level2.list')->with('success', 'Level2 created successfully.');
}

    public function edit($id)
    {
        $level2 = Level2::findOrFail($id);
        $level1s = Level1::all();
        $selectedGroup = $level2->level1_id;
        return view('accounts.level2.edit', get_defined_vars());
    }
   public function update(Request $request, $id)
{
    // Validate the input fields
    $request->validate([
        'title' => 'required|string|max:255',
        'level1_id' => 'required|exists:level1s,id', // Ensures that the selected level1 exists
    ]);

    try {
        // Find the specific Level2 record
        $level2 = Level2::findOrFail($id);

        // Update the Level2 record with new values
        $level2->title = $request->input('title');
        $level2->level1_id = $request->input('level1_id');
        $level2->save();

    } catch (\Exception $e) {
        dd($e->getMessage()); // Debugging message if an error occurs
    }

    // Redirect back to the list page with a success message
    return redirect()->route('level2.list')->with('success', 'Level2 updated successfully');
}


    public function destroy($id)
{
    // Find the Level2 record by ID
    $level2 = Level2::findOrFail($id);
    $trnd = AccountMaster::where('level2_id', $id)
               ->first(); // get first matching record

if ($trnd) {
    // Record exists, return or prevent action
    return back()->with('error', 'this account not allowed delete because is linked with Accounts.');
}
    // Check if the Level2 ID is used in the ERP parameters
    $isUsedInBankLevel = DB::table('erp_params')->where('bank_level', $id)->exists();
    $isUsedInCashLevel = DB::table('erp_params')->where('cash_level', $id)->exists();
    $isUsedInSupplierLevel = DB::table('erp_params')->where('supplier_level', $id)->exists();

    // If the Level2 ID is used, prevent deletion and show an error message
    if ($isUsedInBankLevel || $isUsedInCashLevel || $isUsedInSupplierLevel) {
        return redirect()->route('level2.list')->with('error', 'The "' . $level2->title . '" is used in ERP parameters. To delete, you must first remove it from ERP parameters.');
    }

    // Proceed with deletion
    $level2->delete();

    return redirect()->route('level2.list')->with('success', 'Level2 deleted successfully');
}


}
