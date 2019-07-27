<?php

namespace App\Http\Controllers;

use App\Year;
use App\Player;
use App\MinorLeagueTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Query\Builder;

class MinorLeagueTeamController extends Controller
{
    public function index()
    {
    	$minorLeagueTeams = MinorLeagueTeam::get();

    	return view('minorleagueteams.index', compact('minorLeagueTeams'));
    }

    public function show(MinorLeagueTeam $minorLeagueTeam, Year $year)	
    {
        $players = $minorLeagueTeam->players()
                                    // ->load('stats')
                                    ->wherePivot('year_id', $year->id)
                                    ->join('player_stat', function($join) use ($year, $minorLeagueTeam) {
                                        $join->on('player_stat.player_id', '=', 'players.id')
                                            ->where('player_stat.year_id', $year->id)
                                            ->where('player_stat.minor_league_team_id', $minorLeagueTeam->id);
                                    })
                                    ->join('stats', 'stats.id', '=', 'player_stat.stat_id')
                                    ->select('stats.*', 'players.*')
                                    ->where('stats.plateAppearances', '>=', '100')
                                    ->orderBy('stats.seasonScore', 'desc')
                                    ->get();

                                    

        // select `stats`.*, `player_stat`.`player_id`, `players`.*
        // from `stats` 
        // inner join `player_stat` on `stats`.`id` = `player_stat`.`stat_id` 
        // inner join `players` on `players`.`id` = `player_stat`.`player_id`
        // where `player_stat`.`player_id` in (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54) order by `seasonScore` desc, `seasonScore` desc

        Log::debug($players);                            

    	return view('minorleagueteams.show', compact('minorLeagueTeam', 'level', 'year', 'players'));
    }

    public function year()
    {
        return view('minorleagueteams.year');
    }
}
