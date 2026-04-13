<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaminationMaster extends Model
{
    use HasFactory;
    protected $table = 'lamination_master';

    protected $fillable = [
        'department_id',
        'v_no',
        'lamination_job_sheet_impression',
        'lamination_total_job_sheet_impression',
        'lamination_status',
    ];
}
