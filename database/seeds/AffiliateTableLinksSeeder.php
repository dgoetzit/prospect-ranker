<?php

use Illuminate\Database\Seeder;

class AffiliateTableLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = MajorLeagueTeam::get();

        foreach($teams as $team) {
          $teams = factory(AffiliateTableLink::class)->create([
            'url' => 'https://www.baseball-reference.com/register/affiliate.cgi?id='.$team->abbreviation,
          ]);  
        }
    }
}
