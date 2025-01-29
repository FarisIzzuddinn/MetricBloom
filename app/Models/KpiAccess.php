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
    
    public function kpi()
    {
        return $this->belongsTo(AddKpi::class, 'kpi_id');
    }

    public function bahagian()
    {
        return $this->belongsTo(KpiBahagian::class, 'bahagian_id');  
    }

    public function state()
    {
        return $this->belongsTo(KpiState::class, 'state_id');  
    }

    public function institution()
    {
        return $this->belongsTo(KpiInstitution::class, 'institution_id');  
    }

}
