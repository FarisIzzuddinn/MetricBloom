<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'institutions'; 
    protected $fillable = ['name', 'state_id', 'created_by', 'updated_by', 'deleted_by'];

    // Assign the KPI
    public function kpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_institutions', 'institution_id', 'add_kpi_id')
                    ->withPivot('quarter', 'status', 'pencapaian', 'peratus_pencapaian'); // Add all required pivot fields
    }


    public function kpiInstitutions()
    {
    return $this->hasMany(KpiInstitution::class);
    }

    // 1 institutions only have 1 state
    public function state()
    {
        return $this->belongsTo(State::class);
    }

   
}
