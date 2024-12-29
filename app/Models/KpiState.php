<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiState extends Model
{
    use HasFactory;

    protected $table = 'kpi_states';

    protected $fillable = [
        'add_kpi_id',
        'state_id',
        'pencapaian',
        'peratus_pencapaian',
        'status',
        'quarter',
        'reason'
    ];

    /**
     * Relationships
     */

    // Relationship to the KPI (assuming a KPI model exists)
    public function kpi()
    {
        return $this->belongsTo(AddKpi::class, 'add_kpi_id', 'id');
    }

    // Relationship to the State (assuming a State model exists)
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    

    

    public function bahagian()
    {
        return $this->belongsTo(Bahagian::class);
    }

    /**
     * Accessors & Mutators
     */

    // Example accessor for displaying human-readable status
    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Scopes
     */

    // Scope to filter by quarter
    public function scopeByQuarter($query, $quarter)
    {
        return $query->where('quarter', $quarter);
    }

    // Scope to filter by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
