<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeselamatanInteligen extends Model
{
    protected $table = '_keselamatan_inteligen';
    protected $primaryKey = 'Kod';
    public $timestamps = false;

    use HasFactory;
}
