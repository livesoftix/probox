<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempJobSheetBoxboard extends Model
{
    use HasFactory;

    protected $table = 'temp_job_sheet_boxboard';

    protected $fillable = [
        'job_sheet_id',
        'item_id',
        'length',
        'width',
        'qty',
    ];

    public function jobSheet()
    {
        return $this->belongsTo(TempJobSheet::class, 'job_sheet_id');
    }

    public function item()
    {
        return $this->belongsTo(ItemMaster::class, 'item_id');
    }
}