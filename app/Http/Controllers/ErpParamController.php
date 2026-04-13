<?php

namespace App\Http\Controllers;

use App\Models\Level2;
use App\Models\ErpParam;
use Illuminate\Http\Request;
use App\Models\AccountMaster;

class ErpParamController extends Controller
{
    public function index()
    {
        // $accountMasters = AccountMaster::all();
        $erp_params = ErpParam::with('level2')->get();
        return view('erp_params.list',get_defined_vars());
    }
    public function create()
    {
        $accountMasters = AccountMaster::all();
        $level2s = Level2::all();
        return view('erp_params.create',get_defined_vars());
    }
    public function store(Request $request)
{
    // Apply validation rules
    // $validatedData = $request->validate([
    //     'bank_level' => 'required|string',
    //     'cash_level' => 'required|string',
    //     'supplier_level' => 'required|string'
    //     // 'account_master_id' => 'required|exists:account_masters,id', // Add validation for account_master_id
    // ]);

    // Create the ErpParam and associate it with AccountMaster
    ErpParam::create([
        'bank_level' => $request->bank_level,
        'cash_level' => $request->cash_level,
        'supplier_level' => $request->supplier_level,
        'purchase_account' => $request->purchase_account,
        // 'account_master_id' => $validatedData['account_master_id'], // Ensure account_master_id is passed
    ]);

    return redirect()->route('erp_param.list')->with('success', 'Erp Param created successfully.');
}
public function edit($id)
{
    // Fetch the existing ErpParam by ID
    $erpParam = ErpParam::findOrFail($id);
    $accountMasters = AccountMaster::all();
    // Fetch the available levels
    $level2s = Level2::all();

    // Pass the ErpParam and levels to the view
    return view('erp_params.edit', get_defined_vars());
}

public function update(Request $request, $id)
{
    $erpParam = ErpParam::findOrFail($id);
    $erpParam->update([
        'bank_level' => $request->bank_level,
        'cash_level' => $request->cash_level,
        'employee_level' => $request->employee_level,
        'employee_advance' => $request->employee_advance,
        'supplier_level' => $request->supplier_level,
        'purchase_account' => $request->purchase_account,
        'purchase_return_account' => $request->purchase_return_account,
        'sale_ac' => $request->sale_ac,  // New field added here
        'customer_level' => $request->customer_level,  // New field added here
        'cash_acc' => $request->cash_acc,  // New field added here
        'pur_freight' => $request->pur_freight,  // New field added here
        'pur_freight_exp' => $request->pur_freight_exp,  // New field added here
        'sale_freight' => $request->sale_freight,  // New field added here
        'sale_freight_exp' => $request->sale_freight_exp,  // New field added here
        'salary_level' => $request->salary_level,  // New field added here
    ]);

    return redirect()->route('erp_param.list')->with('success', 'Erp Param updated successfully.');
}


public function destroy($id)
{
    // Find and delete the ErpParam
    $erpParam = ErpParam::findOrFail($id);
    $erpParam->delete();

    return redirect()->route('erp_param.list')->with('success', 'Erp Param deleted successfully.');
}


}
