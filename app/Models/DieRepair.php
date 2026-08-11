<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DieRepair extends Model
{
   protected $fillable = [
    'die_id',
    'repair_date',
    'repair_types',
    'description',
];

protected $casts = [
    'repair_types' => 'array',
    'repair_date' => 'date',
];

    public function die(): BelongsTo
    {
        return $this->belongsTo(
            DieMaster::class,
            'die_id'
        );
    }
}