<?php

use App\Stat;
use App\Year;
use App\Player;
use App\ProfileLink;
use App\SeasonScore;


        $profileLink = ProfileLink::where('link', '/register/team.cgi?id=849e23a7')->first();
        $base_url = config('baseball_reference.base_url');
        $urlToQuery = $base_url . $profileLink->link;

        // I need to get the minor league team, the level, and the year linked to the profileLink

        foreach($profileLink->minorLeagueTeams as $minorLeagueTeam) {
            echo $minorLeagueTeam->pivot->year_id;
            $year_id = $minorLeagueTeam->pivot->year_id;
            echo '</br>';

            $level = $minorLeagueTeam->levels()->where('year_id', $year_id)->first();
            echo $level->name;
            echo '</br>';
                
            $html = file_get_contents($urlToQuery);
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);

            $table = $dom->getElementByID('team_batting');
            $rows = $table->getElementsByTagName("tbody")->item(0)->getElementsByTagName("tr");

            for($i = 0; $i < $rows->length; $i++) {

                $stats = $rows[$i]->getElementsByTagName("td");

                $name = $stats->item(0)->textContent;
                echo '</br>';
                var_dump($name);
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

                $player->stats()->attach($playerStats, [
                    'minor_league_team_id' => $minorLeagueTeam->id, 
                    'level_id' => $level->id, 
                    'year_id' => $level->pivot->year_id,
                ]);

                $minorLeagueTeam->players()->attach($player, [
                    'year_id' => $level->pivot->year_id,
                ]);
            }
        }

?>