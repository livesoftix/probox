<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjDetail extends Model
{
    use HasFactory;

    protected $fillable = ['v_no', 'item_id', 'qty', 'rate', 'cid', 'v_date','type'];

    public function master()
    {
        return $this->belongsTo(StockAdjMaster::class, 'v_no', 'v_no');
    }

    public function item()
    {
        return $this->belongsTo(ItemMaster::class, 'item_id', 'id');
    }
}
