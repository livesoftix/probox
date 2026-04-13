<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErpParam extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank_level',
        'cash_level',
        'employee_level',
        'employee_advance',
        'supplier_level',
        'purchase_account',
        'purchase_return_account',
        'sale_ac',
        'customer_level',
        'cash_acc',
        'pur_freight',
        'sale_freight',
        'sale_freight_exp',
        'pur_freight_exp',
        'salary_level',
        
    ];
    public function cashes()
    {
        return $this->belongsTo(Level2::class, 'cash_level');
    }
    
    public function employees()
    {
        return $this->belongsTo(Level2::class, 'employee_level');
    }
    
     public function employeesadvance()
    {
        return $this->belongsTo(Level2::class, 'employee_advance');
    }
    
    public function accountMasters()
{
    return $this->hasMany(AccountMaster::class, 'level2_id', 'cash_level');
}

    public function banks()
    {
        return $this->belongsTo(level2::class, 'bank_level');
    }
    public function supplier()
    {
        return $this->belongsTo(level2::class, 'supplier_level');
    }
    public function level2()
    {
        return $this->belongsTo(Level2::class, 'cash_level');
    }

    public function cash()
    {
        return $this->hasOne(Cash::class); // Assuming a one-to-one relationship with Cash
    }
    public function accounts()
    {
        return $this->belongsTo(AccountMaster::class, 'purchase_account');
    }
      public function accountreturns()
    {
        return $this->belongsTo(AccountMaster::class, 'purchase_return_account');
    }
    public function saleAcc()
    {
        return $this->belongsTo(AccountMaster::class, 'sale_ac');
    }
    
     public function customer()
    {
        return $this->belongsTo(level2::class, 'customer_level');
    }
    public function salary()
    {
        return $this->belongsTo(level2::class, 'salary_level');
    }
    public function cashAcc()
    {
        return $this->belongsTo(AccountMaster::class, 'cash_acc');
    }
    public function purfreight()
    {
        return $this->belongsTo(AccountMaster::class, 'pur_freight');
    }
    public function purfreightexp()
    {
        return $this->belongsTo(AccountMaster::class, 'pur_freight_exp');
    }
    public function salefreight()
    {
        return $this->belongsTo(AccountMaster::class, 'sale_freight');
    }
    public function salefreightexp()
    {
        return $this->belongsTo(AccountMaster::class, 'sale_freight_exp');
    }
}
