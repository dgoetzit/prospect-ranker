<?php

namespace App\Console\Commands;

use App\Year;
use App\ProfileLink;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\GetMinorLeaguePlayerStats;

class GetMinorLeaguePlayersForPreviousYears extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minor-league-players:get-previous';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will pull all of the players for links from previous years';

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
        $count = Year::count();
        $skip = '1';
        $limit = $count - $skip;
        $years = Year::orderBy('year', 'desc')->skip($skip)->take($limit)->get();

        $profileLinks = ProfileLink::get();

        foreach($profileLinks as $profileLink) {
            dispatch(new GetMinorLeaguePlayerStats($profileLink));
        }
    }
}
