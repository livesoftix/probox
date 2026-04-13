<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolnasMaster extends Model
{
    use HasFactory;

    protected $table = 'solnas_masters';

    protected $fillable = [
        'v_no',
        'v_date',
        'total_helper_impression',
        'total_machine_impression',
        'total_impression',
        'department_id',
        'grand_total_impression'
    ];

    /**
     * If v_date is NOT a proper date column (varchar),
     * disable timestamps or casting
     */
    public $timestamps = false;

    /**
     * Optional: cast numeric values properly
     */
    protected $casts = [
        'total_helper_impression'  => 'decimal:2',
        'total_machine_impression'=> 'decimal:2',
        'total_impression'         => 'decimal:2',
    ];

    /**
     * Department relation (if departments table exists)
     */
    public function department()
    {
        return $this->belongsTo(DepartmentSection::class, 'department_id');
    }
}
