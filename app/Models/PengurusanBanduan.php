<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengurusanBanduan extends Model
{
    protected $table = '_pengurusan_banduan';
    protected $primaryKey = 'Kod';
    public $timestamps = false;

    use HasFactory;
}
