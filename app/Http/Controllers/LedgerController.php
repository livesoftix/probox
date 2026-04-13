<?php

namespace App\Http\Controllers;

use App\Models\TRNDTL;
use Illuminate\Http\Request;
use App\Models\AccountMaster;
use Illuminate\Support\Carbon;

class LedgerController extends Controller
{
  
  
     public function index(Request $request)
{
    $accounts = AccountMaster::all();

    // Fetch query parameters
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $accountId = $request->input('account_title');
    $status = $request->input('status');

    $trndtls = collect();
    $openingBalance = 0;

    if ($startDate && $endDate && $accountId) {
        // Get transactions for the selected account within the date range and status
        $trndtls = Trndtl::where(function ($query) use ($accountId) {
                $query->where('account_id', $accountId)
                      ->orWhere('cash_id', $accountId);
            })
            ->whereBetween('date', [$startDate, $endDate]);

        if ($status) {
            $trndtls->where('status', $status);
        }

        $trndtls = $trndtls->orderBy('date')->get();

        // ====== FIXED OPENING BALANCE CALCULATION ======
        // Get ALL transactions before the start_date (sorted by date)
        $openingTransactions = Trndtl::where(function ($query) use ($accountId) {
                $query->where('account_id', $accountId)
                      ->orWhere('cash_id', $accountId);
            })
            ->where('date', '<', $startDate)
            ->orderBy('date')
            ->get();

        // Compute running balance correctly
        $runningBalance = 0;
        foreach ($openingTransactions as $transaction) {
            // Apply the same debit/credit logic as in the blade file
            if ($transaction->cash_id == $accountId && $transaction->account_id != $accountId) {
                // If cash_id matches but account_id doesn't, swap debit/credit
                $runningBalance += $transaction->credit - $transaction->debit;
            } else {
                // Normal case (debit increases balance, credit decreases)
                $runningBalance += $transaction->debit - $transaction->credit;
            }
        }

        $openingBalance = $runningBalance;
    }

    $accountTitle = AccountMaster::find($accountId)->title ?? 'N/A';

    return view('ledger.list', compact('accounts', 'trndtls', 'openingBalance', 'accountTitle', 'startDate', 'endDate', 'accountId', 'status'));
}
  

}