<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DyeMaster extends Model
{
    use HasFactory;
    protected $table = 'dye_master';

    protected $fillable = [
        'department_id',
        'v_no',
        'dye_job_sheet_impression',
        'dye_total_job_sheet_impression',
        'dye_status',
    ];
}
