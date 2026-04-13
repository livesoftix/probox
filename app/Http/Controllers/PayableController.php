<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TRNDTL;
use App\Models\AccountMaster;

class PayableController extends Controller 
{
    public function index(Request $request)
    {
        $endDate = $request->get('end_date');

        // Aggregate balances by account
        $trndtls = TRNDTL::query()
            ->select('account_id')
            ->selectRaw('SUM(debit) as total_debit')
            ->selectRaw('SUM(credit) as total_credit')
            ->when($endDate, fn($query) => $query->where('date', '<=', $endDate))
            ->groupBy('account_id')
            ->havingRaw('SUM(debit) - SUM(credit) < 0') // only payables
            ->get();

        // Attach account details
        $balances = $trndtls->map(function ($row) {
            $account = AccountMaster::find($row->account_id);
            return (object) [
                'title' => $account?->title ?? 'Unknown',
                'total_debit' => $row->total_debit,
                'total_credit' => $row->total_credit,
                'balance' => $row->total_debit - $row->total_credit,
            ];
        });

        return view('payables.list', [
            'balances' => $balances,
            'endDate' => $endDate,
        ]);
    }
}
