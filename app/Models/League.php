<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'active'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'league_team', 'team_id', 'league_id');
    }
}
