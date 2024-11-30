<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    protected $table = 'institutions'; // The table name
    protected $fillable = ['state_id', 'name', 'description'];

    // Assign the KPI
    public function kpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_institutions', 'institution_id', 'add_kpi_id');
    }

    // dashboard super admin
    public function state()
    {
        return $this->belongsTo(State::class);
    }


    // public function state()
    // {
    //     return $this->belongsTo(State::class);
    // }

    // public function addkpis()
    // {
    //     return $this->hasMany(AddKpi::class);
    // }

    // public function kpis()
    // {
    //     return $this->belongsToMany(AddKpi::class, 'kpi_institution', 'institution_id', 'kpi_id');
    // }
    

    // public function addkpi()
    // {
    //     return $this->belongsToMany(KPI::class, 'kpi_institution');
    // }


    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }

    // public function sectors()
    // {
    //     return $this->hasMany(Sector::class);
    // }

   
}
