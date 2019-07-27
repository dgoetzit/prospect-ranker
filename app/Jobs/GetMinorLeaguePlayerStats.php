<?php

namespace App\Jobs;

use App\Stat;
use App\Year;
use App\Player;
use Carbon\Carbon;
use App\ProfileLink;
use App\SeasonScore;
use App\AdvancedStat;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetMinorLeaguePlayerStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $profileLink;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ProfileLink $profileLink)
    {
        $this->profileLink = $profileLink;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $base_url = config('baseball_reference.base_url');
        $urlToQuery = $base_url . $this->profileLink->link;

        // I need to get the minor league team, the level, and the year linked to the profileLink

        foreach($this->profileLink->minorLeagueTeams as $minorLeagueTeam) {
            $year_id = $minorLeagueTeam->pivot->year_id;

            $level = $minorLeagueTeam->levels()->where('year_id', $year_id)->first();
                
            $html = file_get_contents($urlToQuery);
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);

            $table = $dom->getElementByID('team_batting');
            $rows = $table->getElementsByTagName("tbody")->item(0)->getElementsByTagName("tr");

            for($i = 0; $i < $rows->length; $i++) {

                $stats = $rows[$i]->getElementsByTagName("td");

                $name = $stats->item(0)->textContent;
                $age = $stats->item(1)->textContent;
                $plateAppearances = $stats->item(3)->textContent;
                $atBats = $stats->item(4)->textContent;
                $hits = $stats->item(6)->textContent;
                $doubles = $stats->item(7)->textContent;
                $triples = $stats->item(8)->textContent;
                $homeruns = $stats->item(9)->textContent;
                $walks = $stats->item(13)->textContent;
                $strikeouts = $stats->item(14)->textContent;

                $playerBats = Player::determinePlayerHandedness($name);

                $name = str_replace('*', '', $name);
                $name = str_replace('#', '', $name);
                $playerExists = Player::where('name', $name)->first();

                if($playerExists) {
                    $player = $playerExists;
                } else {
                    $player = new Player;
                    $player->name = $name;
                    $player->bats = $playerBats;
                    $player->save();
                }

                $playerData = [
                    'level' => $level->name,
                    'age' => $age,
                    'plateAppearances' => $plateAppearances,
                    'atBats' => $atBats,
                    'hits' => $hits,
                    'doubles' => $doubles,
                    'triples' => $triples,
                    'homeruns' => $homeruns,
                    'walks' => $walks,
                    'strikeouts' => $strikeouts,
                ];

                $seasonScore = SeasonScore::calculate($playerData);

                // Now that I have the player, I should see if the player already has stats
                $playerStats = new Stat;
                $playerStats->age = $age;
                $playerStats->plateAppearances = $plateAppearances;
                $playerStats->atBats = $atBats;
                $playerStats->hits = $hits;
                $playerStats->doubles = $doubles;
                $playerStats->triples = $triples;
                $playerStats->homeruns = $homeruns;
                $playerStats->walks = $walks;
                $playerStats->strikeouts = $strikeouts;
                $playerStats->seasonScore = $seasonScore;
                $playerStats->save();

                Log::info('Stat Created');

                $player->stats()->attach($playerStats, [
                    'minor_league_team_id' => $minorLeagueTeam->id, 
                    'level_id' => $level->id, 
                    'year_id' => $level->pivot->year_id,
                ]);

                Log::info('Player Stat Relationship Created');

                $minorLeagueTeam->players()->attach($player, [
                    'year_id' => $level->pivot->year_id,
                ]);

                Log::info('Minor League Team Player Relationship Created');
            }
        }
    }
}
