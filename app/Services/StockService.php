<?php

namespace App\Services;

use App\Models\StockAdjMaster;
use App\Models\StockAdjDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockService
{
    public static function addStock($voucherNo, $date, $entries, $type = 'Purchase')
    {
        DB::transaction(function () use ($voucherNo, $date, $entries, $type) {

            // 1. MASTER (create/update)
            StockAdjMaster::updateOrCreate(
                ['v_no' => $voucherNo],
                [
                    'v_date' => $date ?? Carbon::now(),
                    'prepared_by' => Auth::id(),
                    'cid' => Auth::id(),
                ]
            );

            // 2. IMPORTANT: delete ONLY this voucher + type
            StockAdjDetail::where('v_no', $voucherNo)
                ->where('type', $type)
                ->delete();

            // 3. INSERT fresh rows
            foreach ($entries as $entry) {

                $itemId = $entry['item'] ?? null;
                $qty = (float) ($entry['qty'] ?? 0);

                // normalize sign
                $qty = $type === 'Purchase' ? abs($qty) : -abs($qty);

                StockAdjDetail::create([
                    'v_no'    => $voucherNo,
                    'item_id' => $itemId,
                    'qty'     => $qty,
                    'rate'    => $entry['rate'] ?? 0,
                    'v_date'  => $date ?? Carbon::now(),
                    'type'    => $type,
                    'cid' => Auth::id(),
                ]);
            }
        });
    }

    // optional
    public static function getStock($itemId)
    {
        return StockAdjDetail::where('item_id', $itemId)->sum('qty');
    }
}