<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TRNDTL;
use App\Models\AccountMaster;
use App\Models\ProductMaster;
use App\Models\ItemMaster;
use App\Models\PackagingSpec;
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
if ($request->filled('item_id')) {
    $boxboardQuery->where('item_id', $request->item_id);
}
if ($request->filled('length') && $request->filled('width')) {

    $boxboardQuery->where(function ($q) use ($request) {

        $q->where(function ($q1) use ($request) {
            // Normal match
            $q1->where('length', $request->length)
               ->where('width', $request->width);
        })

        ->orWhere(function ($q2) use ($request) {
            // Swapped match
            $q2->where('length', $request->width)
               ->where('width', $request->length);
        });

    });

} else {

    if ($request->filled('length')) {
        $boxboardQuery->where(function ($q) use ($request) {
            $q->where('length', $request->length)
              ->orWhere('width', $request->length);
        });
    }

    if ($request->filled('width')) {
        $boxboardQuery->where(function ($q) use ($request) {
            $q->where('length', $request->width)
              ->orWhere('width', $request->width);
        });
    }

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

   public function searchItem(Request $request)
{
    $term = $request->term;

    $items = ItemMaster::where('item_code', 'like', "%{$term}%")
        ->selectRaw('MIN(id) as id, item_code')
        ->groupBy('item_code')
        ->get();

    return response()->json($items);
}
}