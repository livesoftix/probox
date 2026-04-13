<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrugationDetail extends Model
{
    use HasFactory;
    protected $table = 'corrugation_detail';

    protected $fillable = [
        'v_no',
        'corrugation_date',
        'corrugation_man_id',
        'corrugation_impression',
        'corrugation_waste',
        
    ];

}
