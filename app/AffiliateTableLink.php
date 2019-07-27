<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliateTableLink extends Model
{
    public function major_league_team()
    {
    	return $this->belongsTo(MajorLeagueTeam::class);
    }
}
