<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiInstitution extends Model
{
    use HasFactory;

    protected $table = 'kpi_institutions';

    protected $fillable = [
        'add_kpi_id',
        'institution_id',
        'pencapaian',
        'peratus_pencapaian',
        'status',
        'reason'
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function institutions()
    {
        return $this->belongsTo(KpiInstitution::class, 'institution_id');
    }
    public function kpi()
    {
        return $this->belongsTo(AddKpi::class, 'add_kpi_id');
    }
}
