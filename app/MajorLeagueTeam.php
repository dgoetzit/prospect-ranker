<?php

namespace App;

use App\MinorLeagueTeam;
use Illuminate\Database\Eloquent\Model;

class MajorLeagueTeam extends Model
{
    public function getRouteKeyName()
    {
        return 'abbreviation';
    }

    public function minorLeagueTeams()
    {
    	return $this->belongsToMany(MinorLeagueTeam::class)->withPivot('year_id');
    }

    public function players()
    {
    	return $this->hasManyThrough(Player::class, MinorLeagueTeam::class);
    }

    public function affiliateTable()
    {
    	return $this->hasOne(AffiliateTableLink::class);
    }
}
