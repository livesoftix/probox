<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockManageController extends Controller
{
    //
    public function ink($itemId, $vdate, $which)
    {
        if ($which == 'IPN') {
            $qty = DB::table('ink_stock')
                ->select(
                    DB::raw('sum(p_qty) - sum(r_qty) - sum(job_qty) as remaining_qty')
                )->where('item_id', $itemId)
                ->where('v_date', '<=', $vdate)
                ->get();

            return response()->json([
                'remaining_qty' => $qty[0]->remaining_qty
            ]);
        } elseif ($which == 'PPN') {
            $qty = DB::table('plate_stock')
                ->select(
                    DB::raw('sum(p_qty) - sum(r_qty) - sum(job_qty) as remaining_qty')
                )->where('item_id', $itemId)
                ->where('v_date', '<=', $vdate)
                ->get();

            return response()->json([
                'remaining_qty' => $qty[0]->remaining_qty
            ]);
        } elseif ($which == 'LPN') {
            $qty = DB::table('lamination_stock')
                ->select(
                    DB::raw('sum(p_qty) - sum(r_qty) - sum(job_qty) as remaining_qty')
                )->where('item_id', $itemId)
                ->where('v_date', '<=', $vdate)
                ->get();
        } elseif ($which == 'GPN') {
            $qty = DB::table('glue_stock')
                ->select(
                    DB::raw('sum(p_qty) - sum(r_qty) - sum(job_qty) as remaining_qty')
                )->where('item_id', $itemId)
                ->where('v_date', '<=', $vdate)
                ->get();

            return response()->json([
                'remaining_qty' => $qty[0]->remaining_qty
            ]);
        } elseif ($which == 'DPN') {
            $qty = DB::table('dye_stock')
                ->select(
                    DB::raw('sum(p_qty) - sum(r_qty) - sum(job_qty) as remaining_qty')
                )->where('item_id', $itemId)
                ->where('v_date', '<=', $vdate)
                ->get();

            return response()->json([
                'remaining_qty' => $qty[0]->remaining_qty
            ]);
        }
        elseif ($which == 'SPN') {
            $qty = DB::table('shipper_stock')
                ->select(
                    DB::raw('sum(p_qty) - sum(r_qty) - sum(job_qty) as remaining_qty')
                )->where('item_id', $itemId)
                ->where('v_date', '<=', $vdate)
                ->get();

            return response()->json([
                'remaining_qty' => $qty[0]->remaining_qty
            ]);
        }
    }
    public function lamination($item_id, $v_date, $size)
    {

        $qty = DB::table('lamination_stock')
            ->where('item_id', $item_id)
            ->where('size', $v_date)
            ->where('v_date', '<=', $size)
            ->selectRaw('SUM(p_qty) - SUM(job_qty) - SUM(r_qty) as remaining_qty')
            ->get();

        $remaining_qty = 0;
        foreach ($qty as $q) {
            $remaining_qty += $q->remaining_qty;
        }

        return response()->json([
            'remaining_qty' => $remaining_qty,
            'size' => $v_date
        ]);
    }
}
