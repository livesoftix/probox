<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastingDetail extends Model
{
    use HasFactory;
    protected $table = 'pasting_detail';

    protected $fillable = [
        'v_no',
        'pasting_date',
        'pasting_man_id',
        'pasting_impression',
        'pasting_waste',
        'department_id'
    ];
}
