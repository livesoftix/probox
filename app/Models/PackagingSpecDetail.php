<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingSpecDetail extends Model
{
    use HasFactory;

    protected $table = 'packaging_spec_details';

    protected $fillable = [
        'packaging_spec_id',
        'printing_size',
        'board_size',
        'ups',
    ];

    public function packagingSpec()
    {
        return $this->belongsTo(PackagingSpec::class, 'packaging_spec_id');
    }
}
