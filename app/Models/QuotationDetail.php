<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $table = 'quotation_details';

    protected $fillable = [
        'quotation_id',
        'item_id',
        'item_name',
        'item_details',
        'qty',
        'rate',
        'amount',
        'sort_order',
    ];

    /*
    |--------------------------------------------------------------------------
    | Quotation
    |--------------------------------------------------------------------------
    */

    public function quotation()
    {
        return $this->belongsTo(
            Quotation::class,
            'quotation_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Item
    |--------------------------------------------------------------------------
    */

    public function item()
    {
        return $this->belongsTo(
            ItemMaster::class,
            'item_id'
        );
    }
}