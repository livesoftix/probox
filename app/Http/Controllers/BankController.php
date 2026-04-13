<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\TRNDTL;
use Illuminate\Http\Request;
use App\Models\AccountMaster;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    public function index()
    {
        $accounts = AccountMaster::all();
        return view('bank.list',get_defined_vars());
    }
    public function store(Request $request)
    {
        if ($request->total_debit != $request->total_credit) {
            return redirect()->back()->with('error', 'Total debit and credit amounts must be equal.');
        }
       
foreach ($request->entry_account_title as $index => $accountTitle) {
    
    $debitEntry = $request->entry_debit[$index] ?? 0;
    $creditEntry = $request->entry_credit[$index] ?? 0;
    $entryDate = $request->entry_date[$index]; 
    

    $voucher = TRNDTL::create([
        'v_no' => '1',
        'account_id' => $accountTitle,
        'debit' => $debitEntry,
        'credit' => $creditEntry,
        'date' => $entryDate, 
        'v_type' => 'OPN',
    ]);

}
        foreach ($request->entry_account_title as $index => $accountTitle) {
         
            $debitEntry = $request->entry_debit[$index] ?? 0;
            $creditEntry = $request->entry_credit[$index] ?? 0;
            $entryDate = $request->entry_date[$index]; 
           
            $voucher = Bank::create([
                'account_id' => $accountTitle,
                'debit' => $debitEntry,
                'credit' => $creditEntry,
                'date' => $entryDate, 
            ]);
        }

        return redirect()->back()->with('success', 'OPN-1 has been saved successfully');
    }




}
