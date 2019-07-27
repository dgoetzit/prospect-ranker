<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    public function player()
    {
    	return $this->belongsToMany(Player::class);
    }

    public function advanced_stat()
    {
    	return $this->hasOne(AdvancedStat::class);
    }
}
