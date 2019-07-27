<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProfileLink extends Model
{
    public function minorLeagueTeams()
    {
    	return $this->belongsToMany(MinorLeagueTeam::class)->withPivot('year_id');
    }

}
