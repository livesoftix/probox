<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolnasHelperDetail extends Model
{
    use HasFactory;

    protected $table = 'solnas_helper_details';

    protected $fillable = [
        'v_no',
        'v_date',
        'given_impression',
        'department_id',
        'machine_id',
        'man_id',
    ];

    /**
     * Table does NOT have created_at / updated_at
     */

    /**
     * Cast numeric fields
     */
    protected $casts = [
        'given_impression' => 'decimal:2',
    ];

    /* ===========================
     |        Relationships
     =========================== */

    public function department()
    {
        return $this->belongsTo(DepartmentSection::class, 'department_id');
    }


    public function helper()
    {
        return $this->belongsTo(EmployeeType::class, 'man_id');
    }
}
