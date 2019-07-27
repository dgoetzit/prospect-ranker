<?php

use App\MajorLeagueTeam;
use Illuminate\Database\Seeder;

class MajorLeagueTeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = config('major_league_teams.teams');

        foreach($teams as $key => $team) {
          $teams = factory(MajorLeagueTeam::class)->create([
            'name' => $key,
            'abbreviation' => $team,
            'active' => '1',
          ]);  
        }
    }
}
