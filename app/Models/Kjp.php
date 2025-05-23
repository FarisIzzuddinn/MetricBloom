<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kjp extends Model
{
    use HasFactory;

    protected $table = 'kjps';

    protected $fillable = [
        'name',
    ];

    public function addKpis()
    {
        return $this->belongsToMany(AddKpi::class, 'kpi_kjp', 'kjp_id', 'add_kpi_id');
    }
    
    
    


}
