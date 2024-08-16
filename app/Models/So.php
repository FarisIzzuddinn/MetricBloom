<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class So extends Model
{
    use HasFactory;

    protected $fillable = ['SO']; 

    public function addKpis()
    {
        return $this->hasMany(AddKpi::class, 'so_id');
    }
}
