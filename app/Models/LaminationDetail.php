<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaminationDetail extends Model
{
    use HasFactory;
    protected $table = 'lamination_detail';

    protected $fillable = [
        'department_id',
        'v_no',
        'lamination_date',
        'lamination_man_id',
        'lamination_machine_id',
        'lamination_given_impression',
        'lamination_waste_impression',
    ];
}
