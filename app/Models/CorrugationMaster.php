<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrugationMaster extends Model
{
    use HasFactory;
    protected $table = 'corrugation_master';
    protected $fillable = [
        'v_no',
        'corrugation_total_impression',
        'corrugation_total_waste',
        'total_job_sheet_impression',
        'corrugation_job_impression',
        'status',
    ];
}
