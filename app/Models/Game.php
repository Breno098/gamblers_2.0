<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'time', 'status', 'type', 'user_id', 'team_home_id', 'team_guest_id', 'stadium_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teamHome()
    {
        return $this->hasOne(Team::class, 'team_home_id', 'id');
    }

    public function teamGuest()
    {
        return $this->hasOne(Team::class, 'team_guest_id', 'id');
    }

    public function stadia()
    {
        return $this->hasOne(Stadium::class);
    }
}
