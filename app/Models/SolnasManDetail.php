<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolnasManDetail extends Model
{
    use HasFactory;

    protected $table = 'solnas_man_details';

    protected $fillable = [
        'v_no',
        'v_date',
        'given_impression',
        'total_wastage',
        'department_id',
        'machine_id',
        'man_id',
    ];

    /**
     * Table has no created_at / updated_at
     */
    public $timestamps = false;

    /**
     * Cast numeric fields
     */
    protected $casts = [
        'given_impression' => 'decimal:2',
        'total_wastage'    => 'decimal:2',
    ];

    /* ===========================
     |        Relationships
     =========================== */

    public function department()
    {
        return $this->belongsTo(DepartmentSection::class, 'department_id');
    }


    public function man()
    {
        return $this->belongsTo(EmployeeType::class, 'man_id');
    }
}
