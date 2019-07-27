<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public function minorLeagueTeams()
    {
    	return $this->belongsToMany(MinorLeagueTeam::class);
    }
}
