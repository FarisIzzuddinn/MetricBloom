<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiBahagian extends Model
{
    use HasFactory;

    
    protected $table = 'kpi_bahagian';
    public $timestamps = true;
    protected $fillable = [
        'add_kpi_id',
        'bahagian_id',
        'pencapaian',
        'peratus_pencapaian',
        'status',
    ];
    public function bahagian()
    {
        return $this->belongsTo(Bahagian::class, 'bahagian_id', 'id');
    }

    public function kpi()
    {
        return $this->belongsTo(AddKpi::class, 'add_kpi_id');
    }
}
