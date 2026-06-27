<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TRNDTL;
use App\Models\AccountMaster;
use App\Models\ProductMaster;
use App\Models\ItemMaster;
use Illuminate\Support\Facades\DB;

class BoxboardReportStockController extends Controller
{
    public function boxboard_report(Request $request)
    {
        $items = ItemMaster::all();
        $products = ProductMaster::all();

        $startDate  = $request->input('start_date');
        $endDate    = $request->input('end_date');
        $garmmage    = $request->input('garmmage ');
        $length    = $request->input('length ');
        $width    = $request->input('width ');
        $productType = $request->input('product_type');

        // Stock View Data
       $boxboardQuery = DB::table('boxboard_stock_qty')
    ->select(
        'item_code',
        'width',
        'length',
        'grammage',
        'remain_qty',
        'total_wt'
    );

if ($request->filled('garmmage')) {
    $boxboardQuery->where('grammage', $request->garmmage);
}

if ($request->filled('length')) {
    $boxboardQuery->where('length', $request->length);
}

if ($request->filled('width')) {
    $boxboardQuery->where('width', $request->width);
}

$boxboardData = $boxboardQuery
    ->orderBy('item_code', 'asc')
    ->get();

        // Accounts List
        $accounts = TRNDTL::select('account_id')
            ->distinct()
            ->with('accounts')
            ->where('v_type', 'BPN')
            ->get();

        // Purchase Query (Only BPN)
        $query = TRNDTL::where('v_type', 'BPN')
            ->where('description', '!=', 'Freight')
            ->with(['purchasedetails', 'accounts']);

        // Account Filter
        if ($request->filled('account')) {
            $query->where('account_id', $request->account);
        }

        // Party Filter
        if ($request->filled('party')) {
            $query->where('account_id', $request->party);
        }

        // Date Filter
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        // Purchase Data
        $trndtl = $query
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->orderBy('v_no', 'desc')
            ->get();

        $accountMasters = AccountMaster::all();

        return view('report_stock.index3', [
            'trndtl'         => $trndtl,
            'startDate'      => $startDate,
            'endDate'        => $endDate,
            'products'       => $products,
            'accountMasters' => $accountMasters,
            'items'          => $items,
            'productType'    => $productType,
            'accounts'       => $accounts,
            'boxboardData'   => $boxboardData,
        ]);
    }
}