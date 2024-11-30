<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEntity extends Model
{
    use HasFactory;

    protected $table = 'user_entities';
    protected $fillable = ['user_id', 'state_id', 'institution_id', 'sector_id', 'bahagian_id'];

    protected $attributes = [
        'state_id' => 0,
        'institution_id' => 0,
        'sector_id' => 0,
        'bahagian_id' => 0,
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bahagian()
    {
        return $this->belongsTo(Bahagian::class, 'bahagian_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}
