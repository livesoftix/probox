<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlateJobSheet extends Model
{
    use HasFactory;
        protected $table='plate_job_sheet';

        protected $fillable = ['v_no','v_date','item_id','qty','department_id'];
}
