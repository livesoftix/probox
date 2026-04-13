<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastingMaster extends Model
{
    use HasFactory;
    protected $table = 'pasting_master';

    protected $fillable = [
        'v_no',
        'pasting_total_impression',
        'pasting_total_waste',
        'pasting_job_impression',
        'total_job_sheet_impression',
        'status','department_id'
    ];
      
}
