<?php

namespace App\Console\Commands;

use App\Year;
use Carbon\Carbon;
use App\MajorLeagueTeam;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\GetMinorLeagueAffiliateLinks;

class GetMinorLeagueAffiliatesForCurrentYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'affiliates:get-current';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fire off jobs that will retrieve the minor league affiliates for all major league teams for the given year';

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
        $year = Year::where('year', Carbon::now()->year)->first();

        foreach($majorLeagueTeams as $team) {
            dispatch(new GetMinorLeagueAffiliateLinks($team, $year));
        }
    }
}
