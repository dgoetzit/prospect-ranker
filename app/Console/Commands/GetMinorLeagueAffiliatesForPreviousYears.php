<?php

namespace App\Console\Commands;

use App\Year;
use App\MajorLeagueTeam;
use Illuminate\Console\Command;
use App\Jobs\GetMinorLeagueAffiliateLinks;

class GetMinorLeagueAffiliatesForPreviousYears extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'affiliates:get-previous';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command fires off jobs that get the affiliates for major league teams for the specified year';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $majorLeagueTeams = MajorLeagueTeam::where('active', '1')->get();

        $count = Year::count();
        $skip = '1';
        $limit = $count - $skip;
        $years = Year::orderBy('year', 'desc')->skip($skip)->take($limit)->get();

        foreach($years as $year) {
            foreach($majorLeagueTeams as $team) {
                dispatch(new GetMinorLeagueAffiliateLinks($team, $year));
            }  
        }
    }
}
