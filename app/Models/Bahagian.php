<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahagian extends Model
{
    use HasFactory;

    protected $table = 'bahagian';

    protected $fillable = [
        'nama_bahagian',
    ];

    // public function addKpis()
    // {
    //     return $this->belongsToMany(AddKpi::class, 'kpi_bahagian', 'bahagian_id', 'kpi_id');
    // }

    
    public function addKpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_bahagian')
            ->withPivot('status') // Include the `status` column
            ->withTimestamps();
    }

    public function kpiStates()
    {
        return $this->hasMany(KpiState::class, 'bahagian_id');
    }
    
    public function kpiBahagian()
    {
        return $this->hasMany(KpiBahagian::class, 'bahagian_id');
    }

    public function users()
    {
        return $this->hasMany(UserEntity::class);
    }

    public function kpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_bahagian', 'bahagian_id', 'add_kpi_id');
    }

    // Define the relationship with Sector
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }
}
