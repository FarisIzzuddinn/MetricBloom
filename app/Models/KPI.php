<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPI extends Model
{
    use HasFactory;

    protected $fillable = ['institution_id', 'name', 'description'];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
