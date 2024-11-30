<?php

namespace App\Models;

use App\Models\AddKpi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function kpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_states')
                    ->withTimestamps();
    }

    public function kpiStates()
    {
        return $this->hasMany(KpiState::class, 'state_id');
    }


    // Dashboard super admin
    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }

    // public function kpis()
    // {
    //     return $this->belongsToMany(AddKpi::class, 'kpi_state', 'state_id', 'kpi_id');
    // }

    // public function adminState()
    // {
    //     return $this->hasMany(User::class, 'state_id');
    // }
}
