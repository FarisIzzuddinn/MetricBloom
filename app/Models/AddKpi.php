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
    
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($kpi) {
            if ($kpi->peratus_pencapaian == 100) {
                $kpi->status = 'completed';
            } elseif ($kpi->peratus_pencapaian >= 50) {
                $kpi->status = 'on-going';
            } else {
                $kpi->status = 'not achieved';
            }
        });
    }
    
    public function addKpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_user'); 
    }

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

    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'kpi_sector');
    }
}
