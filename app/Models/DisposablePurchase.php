<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposablePurchase extends Model
{
    use HasFactory;
    protected $table = 'disposable_purchase'; 

    protected $fillable = [
        'item_id',
        'qty',
        'weight_type',
        'rate',
        'amount',
        'voucher_no',
        'freight',
        'freight_type',
        'image'
    ];

    public function item()
    {
        return $this->belongsTo(ItemMaster::class, 'item_id');
    }

    public function trndtls()
    {
        return $this->hasMany(TRNDTL::class, 'r_id');
    }
}
