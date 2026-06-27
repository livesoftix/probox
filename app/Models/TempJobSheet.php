<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempJobSheet extends Model
{
    use HasFactory;

    protected $table = 'temp_job_sheets';

    protected $fillable = [
        'v_no',
        'prepared_by',
        'account_id',
        'product_type',
        'job_id',
        'item_name',
        'length',
        'width',
        'product_name',
        'country_name',
        'size',
        'qty',
        'rate',
        'description','preparedby','printing_for','ups',
        
    'lamination',
    'lam_size',
    'lam_item',

    'corrugation',
    'curr_size',
    'curr_item',

    'color',
    'color_no',

    'window',
    'glass_win',
    'lam_window',

    'uv',
    'simple',
    'spot',
    'tripof',

    'varnish',

    'emboss',
    'emboss_rate',

    'breaking',

    ];

    public function account()
    {
        return $this->belongsTo(AccountMaster::class, 'account_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductMaster::class, 'job_id');
    }

    public function boxboards()
    {
        return $this->hasMany(
            TempJobSheetBoxboard::class,
            'job_sheet_id',
            'id'
        );
    }

     public function lamItem()
    {
        return $this->belongsTo(ItemMaster::class, 'lam_item');
    }
    public function currItem()
    {
        return $this->belongsTo(ItemMaster::class, 'curr_item');
    }
}