<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddKpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'teras_id',
        'sectors_id',
        'pernyataan_kpi',
        'jenis_sasaran',
        'sasaran',
        'pencapaian',
        'peratus_pencapaian',
        'pdf_file_path',
    ];

    
    public function kpiStates()
    {
        return $this->hasMany(KpiState::class, 'add_kpi_id');
    }
    
    public function states()
    {
        return $this->belongsToMany(State::class, 'kpi_states', 'add_kpi_id', 'state_id')
                    ->withPivot('status', 'peratus_pencapaian') // Include the 'status' column
                    ->withTimestamps();   // Include timestamps from the pivot table
    }

    public function institutions()
    {
        return $this->belongsToMany(Institution::class, 'kpi_institutions', 'add_kpi_id', 'institution_id')
                    ->withPivot('status', 'pencapaian', 'peratus_pencapaian'); // Add all required pivot fields
    }

    public function bahagians()
    {
        return $this->belongsToMany(Bahagian::class, 'kpi_bahagian', 'add_kpi_id', 'bahagian_id')
                    ->withPivot('status', 'peratus_pencapaian') // Include the 'status' column
                    ->withTimestamps();   // Include timestamps from the pivot table
    }
    
    public function kpiBahagian()
    {
        return $this->hasMany(KpiBahagian::class, 'add_kpi_id');
    }


    public function achievement()
    {
        return $this->hasOne(KpiBahagian::class, 'add_kpi_id');
    }

    public function teras()
    {
        return $this->belongsTo(Teras::class, 'teras_id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sectors_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($kpi) {
            if ($kpi->peratus_pencapaian == 100) {
                $kpi->status = 'achieved';
            } elseif ($kpi->peratus_pencapaian >= 50) {
                $kpi->status = 'pending';
            } else {
                $kpi->status = 'not achieved';
            }
        });
    }

    // public function sector()
    // {
    //     return $this->belongsTo(Sector::class);
    // }
    
    
    // public function bahagians()
    // {
    //     return $this->belongsToMany(Bahagian::class, 'kpi_bahagian', 'kpi_id', 'bahagian_id');
    // }
    
    // public function addKpis()
    // {
    //     return $this->belongsToMany(AddKpi::class, 'kpi_user'); 
    // }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'kpi_user', 'kpi_id', 'user_id');
    // }
   

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'institution_admin_id');
    // }

    // public function userss()
    // {
    //     return $this->belongsToMany(User::class, 'institution_add_kpi', 'add_kpi_id', 'institution_id');
    // }

    

    // public function so()
    // {
    //     return $this->belongsTo(So::class, 'so_id');
    // }

    // public function states()
    // {
    //     return $this->belongsToMany(State::class, 'kpi_state', 'kpi_id', 'state_id');
    // }

    // public function institutions()
    // {
    //     return $this->belongsToMany(Institution::class, 'kpi_institution', 'kpi_id', 'institution_id');
    // }

    // public function userSector()
    // {
    //     return $this->belongsToMany(User::class, 'institution_add_kpi', 'add_kpi_id');
    // }

    // public function sectors()
    // {
    //     return $this->belongsToMany(Sector::class, 'kpi_sector');
    // }
}
