<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'country_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function leagues()
    {
        return $this->belongsToMany(League::class, 'league_team', 'team_id', 'league_id');
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

}
