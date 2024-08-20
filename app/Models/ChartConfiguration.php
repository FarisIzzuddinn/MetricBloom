<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartConfiguration extends Model
{
    use HasFactory;

    protected $table = 'chart_rename';
    
    protected $fillable = [
        'chart_title',
    ];
}
