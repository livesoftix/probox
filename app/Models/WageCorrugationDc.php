<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WageCorrugationDc extends Model
{
    use HasFactory;

    protected $fillable = [
        'b_no',
        'v_no',
        'dc_date',
        'account_id',
        'prod_id',
        'product_name',
        'qty',
        'clabour',
        'corrugation_wage',
        'total_amount',
        'dc_type',
        'date',
        'prepared_by',
        'v_type',
        'employee_id',
        'previous_loan',
        'deduction',
        'remaining_loan','other_exp','description','batch_no'
    ];
    public function employee()
{
    return $this->belongsTo(Employees::class, 'employee_id');
}
}