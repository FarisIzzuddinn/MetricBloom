<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDashboard extends Model
{
    use HasFactory;
    protected $fillable = ['sortby', 'negeri', 'pemilik', 'kpi', 'penyataan_kpi', 
    'sasaran', 'jenis_sasaran', 'pencapaian', 'peratus_pencapaian', 'status'];
}
