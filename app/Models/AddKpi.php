<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddKpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'bil','teras_id', 'so_id',  'kpi', 'pernyataan_kpi',
        'sasaran', 'jenis_sasaran', 'pencapaian', 'peratus_pencapaian', 'status', 'institution_admin_id'
    ];

    // Institution Admin
    public function users()
    {
        return $this->belongsToMany(User::class, 'kpi_user', 'kpi_id', 'user_id');
    }
   

    public function user()
    {
        return $this->belongsTo(User::class, 'institution_admin_id');
    }

    public function userss()
    {
        return $this->belongsToMany(User::class, 'institution_add_kpi', 'add_kpi_id', 'institution_id');
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'kpi_state')
    //                 ->withPivot('state_id'); // Assuming state_id is in the pivot table
    // }

    public function teras()
    {
        return $this->belongsTo(Teras::class, 'teras_id');
    }

    public function so()
    {
        return $this->belongsTo(So::class, 'so_id');
    }

    public function states()
    {
        return $this->belongsToMany(State::class, 'kpi_state', 'kpi_id', 'state_id');
    }

    public function institutions()
    {
        return $this->belongsToMany(Institution::class, 'kpi_institution', 'kpi_id', 'institution_id');
    }

    public function userSector()
    {
        return $this->belongsToMany(User::class, 'institution_add_kpi', 'add_kpi_id');
    }
}
