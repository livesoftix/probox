<?php

namespace App\Http\Controllers;

use App\Models\AccountMaster;
use App\Models\ChequeMaster;
use App\Models\ErpParam;
use App\Models\Group;
use App\Models\Level1;
use App\Models\Level2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyStatementController extends Controller
{
    public function reports(Request $request)
    {
        // -------------------------------
        // Get End Date
        // -------------------------------
        $defaultEndDate = now()->format('Y-m-d');
        $endDate = $request->get('end_date', $defaultEndDate);

        $erp = ErpParam::first();

        // -------------------------------
        // Level 5 Accounts (Bank)
        // -------------------------------
        $level5Accounts = AccountMaster::where('level2_id', $erp->bank_level)->get();
        $level5AccountIds = $level5Accounts->pluck('id')->toArray();

        $level5Transactions = DB::table('trn_dtl_views')
            ->whereIn('aid', $level5AccountIds)
            ->when($endDate, fn($q) => $q->whereDate('v_date', '<=', $endDate))
            ->select(
                'aid as account_id',
                DB::raw('IFNULL(SUM(debit),0) - IFNULL(SUM(credit),0) AS balance'),
                DB::raw('MAX(v_date) as last_transaction_date')
            )
            ->groupBy('aid')
            ->get();

        $level5Accounts = $level5Accounts->sortBy(function ($account) use ($level5Transactions) {
            return $level5Transactions->firstWhere('account_id', $account->id) ? 0 : 1;
        })->values();

        // -------------------------------
        // Level 7 Accounts (Customer)
        // -------------------------------
        $level7Accounts = AccountMaster::where('level2_id', $erp->customer_level)->get();
        $level7AccountIds = $level7Accounts->pluck('id')->toArray();

        $level7Transactions = DB::table('trn_dtl_views')
            ->whereIn('aid', $level7AccountIds)
            ->when($endDate, fn($q) => $q->whereDate('v_date', '<=', $endDate))
            ->select(
                'aid as account_id',
                DB::raw('IFNULL(SUM(debit),0) - IFNULL(SUM(credit),0) AS balance'),
                DB::raw('MAX(v_date) as last_transaction_date')
            )
            ->groupBy('aid')
            ->get();

        $level7Accounts = $level7Accounts->sortBy(function ($account) use ($level7Transactions) {
            return $level7Transactions->firstWhere('account_id', $account->id) ? 0 : 1;
        })->values();

        // -------------------------------
        // Level 6 Accounts (Cash)
        // -------------------------------
        $level6Accounts = AccountMaster::where('level2_id', $erp->cash_level)->get();
        $level6AccountIds = $level6Accounts->pluck('id')->toArray();

        $level6Transactions = DB::table('trn_dtl_views')
            ->whereIn('aid', $level6AccountIds)
            ->when($endDate, fn($q) => $q->whereDate('v_date', '<=', $endDate))
            ->select(
                'aid as account_id',
                DB::raw('IFNULL(SUM(debit),0) - IFNULL(SUM(credit),0) AS balance'),
                DB::raw('MAX(v_date) as last_transaction_date')
            )
            ->groupBy('aid')
            ->get();

        $level6Accounts = $level6Accounts->sortBy(function ($account) use ($level6Transactions) {
            return $level6Transactions->firstWhere('account_id', $account->id) ? 0 : 1;
        })->values();

        // -------------------------------
        // Level 14 Accounts (Assets)
        // -------------------------------
        $assetsGroupId = Group::where('title', 'Assets')->value('id');
        $level1Ids = Level1::where('group_id', $assetsGroupId)->pluck('id');
        $level2Ids = Level2::where('level1_id', 2)->pluck('id');

        $level14Accounts = AccountMaster::whereIn('level2_id', $level2Ids)->get();
        $level14AccountIds = $level14Accounts->pluck('id')->toArray();

        $level14Transactions = DB::table('trn_dtl_views')
            ->whereIn('aid', $level14AccountIds)
            ->when($endDate, fn($q) => $q->whereDate('v_date', '<=', $endDate))
            ->select(
                'aid as account_id',
                DB::raw('IFNULL(SUM(debit),0) - IFNULL(SUM(credit),0) AS balance'),
                DB::raw('MAX(v_date) as last_transaction_date')
            )
            ->groupBy('aid')
            ->get();

        $level14Accounts = $level14Accounts->sortBy(function ($account) use ($level14Transactions) {
            return $level14Transactions->firstWhere('account_id', $account->id) ? 0 : 1;
        })->values();

        // -------------------------------
        // Level 4 Accounts (Supplier)
        // -------------------------------
        $level4Accounts = AccountMaster::where('level2_id', $erp->supplier_level)->get();
        $level4AccountIds = $level4Accounts->pluck('id')->toArray();

        $level4Transactions = DB::table('trn_dtl_views')
            ->whereIn('aid', $level4AccountIds)
            ->when($endDate, fn($q) => $q->whereDate('v_date', '<=', $endDate))
            ->select(
                'aid as account_id',
                DB::raw('IFNULL(SUM(debit),0) - IFNULL(SUM(credit),0) AS balance'),
                DB::raw('MAX(v_date) as last_transaction_date')
            )
            ->groupBy('aid')
            ->get();

        $level4Accounts = $level4Accounts->sortBy(function ($account) use ($level4Transactions) {
            return $level4Transactions->firstWhere('account_id', $account->id) ? 0 : 1;
        })->values();

        // -------------------------------
        // Pending Cheques
        // -------------------------------
        $pendingCheques = ChequeMaster::where('chq_status', 'Pending')
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
            ->select(
                'aid',
                DB::raw('SUM(chq_amt) as chq_amt'),
                DB::raw('MAX(DATE(created_at)) as last_transaction_date')
            )
            ->groupBy('aid')
            ->get();

        // -------------------------------
        // Return view
        // -------------------------------
        return view('daily_statement.index', compact(
            'level7Accounts',
            'level4Accounts',
            'level6Accounts',
            'level14Accounts',
            'level14Transactions',
            'level6Transactions',
            'level7Transactions',
            'level4Transactions',
            'level5Accounts',
            'level5Transactions',
            'pendingCheques',
            'endDate'
        ));
    }
}
