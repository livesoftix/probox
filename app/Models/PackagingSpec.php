<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingSpec extends Model
{
    use HasFactory;

    protected $table = 'packaging_specs';

    protected $fillable = [
        'date',
        'company_name',
        'item_name',
        'unit',
        'length',
        'width',
        'height',
        'lam_size',
        'flute_size',
        'glue_flap',
        'holding_flap',
        'pendi',
        'die_grip',
        'lamination',
        'shine_lamination',
        'matte_lamination',
        'uv_plain',
        'uv_spot',
        'uv_drip',
        'window_glass',
        'window_lamination',
        'emboss',
        'demboss',
        'image_path',
        'type_id',
        'box_type','printing_side','designing_color','silver_finish','gold_finish','country','die_pattern',
    ];

    public function boxType()
    {
        return $this->belongsTo(ItemMaster::class, 'type_id');
    }

    public function details()
    {
        return $this->hasMany(PackagingSpecDetail::class, 'packaging_spec_id');
    }
}
