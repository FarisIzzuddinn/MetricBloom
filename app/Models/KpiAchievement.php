<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiAchievement extends Model
{
    use HasFactory;

    protected $table = 'kpi_achievement';
    
    protected $fillable = [
        'kpi_id',
        'state_id',
        'institution_id',
        'sector_id',
        'achievement_date',
        'actual_value',
        'target_value',
        'status',
    ];

    // Relationships
    public function kpi()
    {
        return $this->belongsTo(AddKpi::class, 'kpi_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }
}
