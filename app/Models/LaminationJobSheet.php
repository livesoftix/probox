<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaminationJobSheet extends Model
{
    use HasFactory;
        use HasFactory;
    protected $table='lamination_job_sheet';

        protected $fillable = ['v_no','v_date','item_id','qty','department_id','size'];
}
