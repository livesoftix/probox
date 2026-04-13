<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DyeDetail extends Model
{
    use HasFactory;
    protected $table = 'dye_detail';

    protected $fillable = [
        'department_id',
        'v_no',
        'dye_date',
        'dye_man_id',
        'dye_machine_id',
        'dye_given_impression',
        'dye_waste_impression',
    ];
}
