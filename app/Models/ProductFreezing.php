<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFreezing extends Model
{
    use HasFactory;
    protected $fillable = [
    'date',
    'slip_no',
    'product_id',
    'description',
    'prepared_by',
    'production_by',
    ];
    public function product()
{
    return $this->belongsTo(ProductMaster::class,'product_id');
}
}
