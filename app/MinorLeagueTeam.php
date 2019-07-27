<?php

namespace App;

use App\MajorLeagueTeam;
use Illuminate\Database\Eloquent\Model;

class MinorLeagueTeam extends Model
{
    public function majorLeagueTeams()
    {
    	return $this->belongsToMany(MajorLeagueTeam::class);
    }

    public function players()
    {
    	return $this->belongsToMany(Player::class)->withPivot('year_id');
    }

    public function levels()
    {
    	return $this->belongsToMany(Level::class)->withPivot('year_id');
    }

    public function profileLinks()
    {
        return $this->belongsToMany(ProfileLink::class)->withPivot('link_id');
    }

}
