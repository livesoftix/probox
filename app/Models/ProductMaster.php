<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaster extends Model
{
    use HasFactory;

    protected $table = 'product_master';  // Table name
    protected $fillable = [
        'aid',        // Foreign key for the account (supplier)
        'prod_name',  // Product Name
        'country_id', // Foreign key for the country
        'item_id',    // Foreign key for the item
        'grammage',   // Grammage
        'length',     // Length
        'width',      // Width
        'rate',       // Rate
        'ups',       // Rate
        'descr',      // Description
        'lamination', // Lamination (1 if checked, 0 if not)
        'lam_size',   // Size for lamination
        'lam_item',   // Item type for lamination
        'uv',         // UV (1 if checked, 0 if not)
        'corrugation',// Corrugation (1 if checked, 0 if not)
        'curr_size',  // Size for corrugation
        'curr_item',  // Item type for corrugation
        'color',      // Color (1 if checked, 0 if not)
        'color_no',   // Number of colors
        'file_path',
        'product_type',
        'simple',
        'spot',
        'limpression',
        'clabour',
        'breaking_rate',
        'manual_pasting_rate',
        'auto_pasting_rate',
        'spot_rate',
        'simple_rate',
        'window',
        'varnish' 
        ,'grain_hard_side'
        ,'tripof'
        ,'tripof_rate',
        'design_color',
        'Glass_w_rate',
        'Lam_w_rate', 
        'glass_win',
        'lam_win',
        'emboss',
        'emboss_rate',
        'job_assign','status'
    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
   public function items()
{
    return $this->belongsTo(ItemMaster::class, 'item_id');
}
    public function lamItem()
    {
        return $this->belongsTo(ItemMaster::class, 'lam_item');
    }
    public function currItem()
    {
        return $this->belongsTo(ItemMaster::class, 'curr_item');
    }
    public function account()
    {
        return $this->belongsTo(AccountMaster::class, 'aid');
    }
    public function freezings()
{
    return $this->hasMany(ProductFreezing::class,'product_id');
}
    
}
