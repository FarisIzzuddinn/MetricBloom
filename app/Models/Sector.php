<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function kpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_sector'); // Many-to-many relationship
    }
}
