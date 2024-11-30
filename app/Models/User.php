<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPasswordTrait, HasRoles;
     
    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'salt', 'state_id', 'institution_id', 'sector_id', 'bahagian_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function states()
    {
        return $this->belongsToMany(State::class, 'user_entities', 'user_id', 'state_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function institutions()
    {
        return $this->belongsToMany(Institution::class, 'user_entities', 'user_id', 'institution_id');
    }

    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'user_entities', 'user_id', 'sector_id');
    }

    public function bahagian()
    {
        return $this->belongsToMany(Bahagian::class, 'user_entities', 'user_id', 'bahagian_id');
    }

    public function userEntity()
    {
        return $this->hasOne(UserEntity::class, 'user_id');
    }

    // public function addKpis()
    // {
    //     return $this->hasMany(AddKpi::class);
    // }

    // public function state()
    // {
    //     return $this->belongsTo(State::class, 'kpi_state', 'user_id', 'state_id');
    // }

    // public function institution()
    // {
    //     return $this->belongsTo(Institution::class);
    // }

    // public function kpis()
    // {
    //     return $this->belongsToMany(AddKpi::class, 'institution_add_kpi', 'institution_id', 'kpi_id');
    // }

    // public function addkpi()
    // {
    //     return $this->belongsToMany(AddKpi::class, 'kpi_user');
    // }

    // public function kpi()
    // {
    //     return $this->belongsToMany(AddKpi::class, 'institution_add_kpi', 'institution_id', 'add_kpi_id');
    // }

    // // Institution Admin 
    // public function kpis()
    // {
    //     return $this->belongsToMany(AddKpi::class, 'kpi_user', 'user_id', 'kpi_id');
    // }

    // public function sector()
    // {
    //     return $this->belongsTo(Sector::class);
    // }
}

