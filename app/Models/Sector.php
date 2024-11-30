<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sector extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public $timestamps = true;

    public function addKpis()
    {
        return $this->hasMany(AddKpi::class);
    }

    // Define the relationship with Bahagian
    public function bahagians()
    {
        return $this->hasMany(Bahagian::class, 'sector_id');
    }
}
