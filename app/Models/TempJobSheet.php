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
        'description','preparedby','printing_for'
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
}