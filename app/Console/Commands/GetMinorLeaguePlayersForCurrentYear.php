<?php

namespace App\Console\Commands;

use App\ProfileLink;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\GetMinorLeaguePlayerStats;

class GetMinorLeaguePlayersForCurrentYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minor-league-players:get-current';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command dispatches a job to get the players from each minor league team';

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
        Log::info('GetMinorLeaguePlayers');
        $profileLinks = ProfileLink::get();

        foreach($profileLinks as $profileLink) {
            Log::info('Job dispatched');
            dispatch(new GetMinorLeaguePlayerStats($profileLink));
        }
    }
}
