<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DieRepeat extends Model
{
    protected $fillable = [
        'die_id',
        'back_date',
        'repeat_date',
        'description',
    ];

    protected $casts = [
        'back_date' => 'date',
        'repeat_date' => 'date',
    ];

    public function die()
    {
        return $this->belongsTo(DieMaster::class);
    }
}