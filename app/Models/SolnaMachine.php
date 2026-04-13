<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolnaMachine extends Model
{
    use HasFactory;

    protected $table = 'solna_machine';

    protected $primaryKey = 'id';

    public $timestamps = true; // set true if you add created_at / updated_at

    protected $fillable = [
        'solna_date_helper',
        'solna_machine_helper',
        'solna_helper',
        'solna_helper_impression',
        'solna_man_waste',
        'v_no',
    ];
    
    
   
    protected $casts = [
        'solna_helper_impression' => 'decimal:2',
        'solna_man_waste'         => 'decimal:2',
    ];
    
    
    
    
}
