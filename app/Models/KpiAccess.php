<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiAccess extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kpi_access';
    protected $fillable = ['kpi_id', 'user_id', 'assigned_by', 'deleted_by'];
    protected $dates = ['deleted_at']; 

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Relationship with the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with the kpi
     */
    public function kpi()
    {
        return $this->belongsTo(AddKpi::class, 'kpi_id');
    }
}
