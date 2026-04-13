<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'level2_id',
        'title',
        'opening_date',
        'account_code'
    ];
    public function erpParams_cash()
    {
        return $this->hasMany(ErpParam::class, 'cash_level');
    }
    public function erpParams_bank()
    {
        return $this->hasOne(ErpParam::class, 'bank_level');
    }
    public function erps()
    {
        return $this->belongsTo(ErpParam::class, 'purchase_account');
    }
    public function level2s()
    {
        return $this->belongsTo(Level2::class, 'level2_id');
    }
    public function cashTrndtls()
    {
        return $this->hasMany(Trndtl::class, 'cash_id');
    }

    public function accountTrndtls()
    {
        return $this->hasMany(Trndtl::class, 'account_id');
    }
    public function deliverymasters()
    {
        return $this->hasMany(DeliveryMaster::class, 'account_id');
    }
}
