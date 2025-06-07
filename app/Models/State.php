<?php

namespace App\Models;

use App\Models\AddKpi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function kpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_states')
                    ->withTimestamps();
    }

    public function kpiStates()
    {
        return $this->hasMany(KpiState::class, 'state_id');
    }


    // 1 state can have more than 1 institutions 
    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }
}
