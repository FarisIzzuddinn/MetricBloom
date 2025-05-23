<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiKjp extends Model
{
    use HasFactory;

    protected $table = 'kpi_kjp';

    protected $fillable = ['add_kpi_id', 'id'];

    public function kpi()
    {
        return $this->belongsTo(AddKpi::class, 'add_kpi_id', 'id');
    }
}
