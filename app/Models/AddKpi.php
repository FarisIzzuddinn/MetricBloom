<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddKpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'bil','teras_id', 'so_id', 'negeri', 'user_id', 'kpi', 'pernyataan_kpi',
        'sasaran', 'jenis_sasaran', 'pencapaian', 'peratus_pencapaian', 'status',
    ];

    // Definisi hubungan dengan model User
    // In AddKpi.php
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teras()
    {
        return $this->belongsTo(Teras::class, 'teras_id');
    }

    public function so()
    {
        return $this->belongsTo(So::class, 'so_id');
    }


}
