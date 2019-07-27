<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $guarded = [];

    public function stats()
    {
    	return $this->belongsToMany(Stat::class)->withPivot(['year_id', 'minor_league_team_id'])->orderBy('seasonScore', 'desc');
    }

    public function minorLeagueTeams()
    {
    	return $this->belongsToMany(MinorLeagueTeam::class);
    }

    public function majorLeagueTeams()
    {
    	return $this->hasManyThrough(MajorLeagueTeam::class, MinorLeagueTeam::class);
    }

    public static function determinePlayerHandedness($name)
    {
        if(strpos($name, '#')) {
            $playerBats = 'switch';
        } elseif(strpos($name, '*')) {
            $playerBats = 'left';
        } else {
            $playerBats = 'right';
        }

        return $playerBats;
    }

}
