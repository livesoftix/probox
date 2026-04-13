<?php

namespace App\Http\Controllers;

use App\Models\TRNDTL;
use App\Models\ChequeMaster;
use Illuminate\Http\Request;
use App\Models\AccountMaster;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{


public function reports(Request $request)
{
    // Get the first day of current month
    $firstDayOfMonth = Carbon::now()->firstOfMonth()->format('Y-m-d');
    // Get the latest date from the `t_r_n_d_t_l_s` table
    $latestDate = DB::table('t_r_n_d_t_l_s')->max('date');

    
     $query = DB::table('t_r_n_d_t_l_s as t')
    ->join('COA as c', 't.account_id', '=', 'c.acc_id')
    ->join('account_masters as a', 't.account_id', '=', 'a.id')
    ->whereIn('c.group_id', [2, 5])
    ->select(
        DB::raw('MAX(t.date) as latest_date'),
        'c.LEVEL2_TITLE',
        'a.title as account_title',
        DB::raw('SUM(t.debit) as total_amount')
    )
    ->groupBy('c.LEVEL2_TITLE', 'a.title')
    ->orderBy('latest_date', 'desc');
    

    // **Filter by selected date range if provided**
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $startDate = Carbon::parse($request->start_date)->format('Y-m-d');
        $endDate = Carbon::parse($request->end_date)->format('Y-m-d');
        $query->whereBetween('t.date', [$startDate, $endDate]);
    } else {
        // **If no date filter is applied, show records from 1st of current month to latest date**
        $query->whereBetween('t.date', [$firstDayOfMonth, $latestDate]);
    }

    if ($request->filled('status')) {
        $query->where('t.status', $request->status);
    }

    if ($request->filled('level2_title')) {
        $query->where('c.LEVEL2_TITLE', $request->level2_title);
    }

    $result = $query->get();

    $level2Titles = DB::table('COA')
        ->whereIn('group_id', [2, 5])
        ->pluck('LEVEL2_TITLE')
        ->unique();

    return view('expense.index', compact('result', 'level2Titles'));
}


}
