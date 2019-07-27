<?php

namespace App\Http\Controllers;

use App\Year;
use App\MajorLeagueTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MajorLeagueTeamController extends Controller
{
    public function index()
    {
    	// $majorLeagueTeams = MajorLeagueTeam::select('name', 'abbreviation')->get();
        $majorLeagueTeams = MajorLeagueTeam::get();

    	return view('majorleagueteams.index', compact('majorLeagueTeams'));
    }

    public function show(MajorLeagueTeam $majorLeagueTeam)
    {
        $years = Year::get();
    	Log::debug($majorLeagueTeam);
    	return view('majorleagueteams.show', compact('majorLeagueTeam', 'years'));
    }

    public function year(MajorLeagueTeam $majorLeagueTeam, Year $year)
    {
        return view('majorleagueteams.year');
    }
}
