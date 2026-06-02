<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'v_no',
        'item_id',
        'item_code',
        'qty',
        'rate',
        'width',
        'length',
        'grammage',
        'amount',
        'total_wt',
        'freight',
        'cid',
        'v_date',
        'type','account_id'];

    public function master()
    {
        return $this->belongsTo(StockAdjMaster::class, 'v_no', 'v_no');
    }
    public function accounts()
    {
        return $this->belongsTo(AccountMaster::class, 'account_id','id');
    }

    public function item()
    {
        return $this->belongsTo(ItemMaster::class, 'item_id', 'id');
    }
}
