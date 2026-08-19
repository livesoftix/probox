<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'quotations';

    protected $fillable = [
        'quotation_no',
        'quotation_date',
        'party_name',
        'description',
        'terms_conditions',
        'created_by',
        'updated_by',
    ];

    public function details()
    {
        return $this->hasMany(
            QuotationDetail::class,
            'quotation_id'
        )->orderBy('sort_order');
    }
}