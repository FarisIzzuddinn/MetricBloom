<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahagian extends Model
{
    use HasFactory;

    protected $table = 'bahagian';

    protected $fillable = [
        'nama_bahagian', 'sector_id'
    ];

    // public function addKpis()
    // {
    //     return $this->belongsToMany(AddKpi::class, 'kpi_bahagian', 'bahagian_id', 'kpi_id');
    // }

    
    public function addKpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_bahagian')
            ->withPivot('status', 'pencapaian') // Include the `status` column
            ->withTimestamps();
    }

    public function kpiStates()
    {
        return $this->hasMany(KpiState::class, 'bahagian_id');
    }

    public function kpiBahagians()
    {
        return $this->hasMany(KpiBahagian::class);
    }

    public function users()
    {
        return $this->hasMany(UserEntity::class);
    }

    public function kpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_bahagian', 'bahagian_id', 'add_kpi_id');
    }

    // ----------------- sector kpi ----------------------------

    public function kpiBahagian()
    {
        return $this->hasMany(KpiBahagian::class, 'bahagian_id');
    }
    
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }
}
