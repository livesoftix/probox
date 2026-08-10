<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DieMaster extends Model
{
    protected $table = 'die_masters';

    protected $fillable = [
    'product_id',
    'item_id',
    'item_name',
    'length',
    'width',
    'no_of_ups',
    'rate',
    'type',
    'repeat_date',
    'repair_count',
    'description',
    ];

    protected $casts = [
        'length' => 'decimal:3',
        'width' => 'decimal:3',
        'no_of_ups' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            ProductMaster::class,
            'product_id'
        );
    }
    public function repairs(): HasMany
{
    return $this->hasMany(
        DieRepair::class,
        'die_id'
    );
}
}