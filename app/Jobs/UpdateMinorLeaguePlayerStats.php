<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateMinorLeaguePlayerStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // What I need to do here is get all of the profile links
        // Associated with minor league teams 
        $base_url = config('baseball_reference.base_url');

        $profileLinks = ProfileLink::get();

        foreach($profileLinks as $profileLink) {
            $urlToQuery = $base_url . $profileLink->link;
            foreach($urlToQuery as $url) {

                $html = file_get_contents($html);
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

                    $scaleFactor = .001;

                    if ($age == 17 && $level == 'A') {
                        $ageFactor = 14;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 14;
                        $hitFactor = 14;
                    } elseif ($age == 18 && $level == 'A') {
                        $ageFactor = 13;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 13;
                        $hitFactor = 13;
                    } elseif ($age == 19 && $level == 'A') {
                        $ageFactor = 12;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 12;
                        $hitFactor = 12;
                    } elseif ($age == 20 && $level == 'A') {
                        $ageFactor = 11;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 11;
                        $hitFactor = 11;
                    } elseif ($age == 21 && $level == 'A') {
                        $ageFactor = 10;
                        $walkFactor = 10;
                        $strikeoutFactor = 1;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age == 22 && $level == 'A') {
                        $ageFactor = 9;
                        $walkFactor = 9;
                        $strikeoutFactor = 2;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age == 23 && $level == 'A') {
                        $ageFactor = 8;
                        $walkFactor = 8;
                        $strikeoutFactor = 3;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age == 24 && $level == 'A') {
                        $ageFactor = 7;
                        $walkFactor = 7;
                        $strikeoutFactor = 4;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age == 25 && $level == 'A') {
                        $ageFactor = 6;
                        $walkFactor = 6;
                        $strikeoutFactor = 5;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age >= 26 && $level == 'A') {
                        $ageFactor = 5;
                        $walkFactor = 5;
                        $strikeoutFactor = 6;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    }

                    if ($age == 17 && $level == 'A+') {
                        $ageFactor = 14;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 14;
                        $hitFactor = 14;
                    } elseif ($age == 18 && $level == 'A+') {
                        $ageFactor = 13;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 13;
                        $hitFactor = 13;
                    } elseif ($age == 19 && $level == 'A+') {
                        $ageFactor = 12;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 12;
                        $hitFactor = 12;
                    } elseif ($age == 20 && $level == 'A+') {
                        $ageFactor = 11;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 11;
                        $hitFactor = 11;
                    } elseif ($age == 21 && $level == 'A+') {
                        $ageFactor = 10;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age == 22 && $level == 'A+') {
                        $ageFactor = 9;
                        $walkFactor = 9;
                        $strikeoutFactor = 1;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age == 23 && $level == 'A+') {
                        $ageFactor = 8;
                        $walkFactor = 8;
                        $strikeoutFactor = 2;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age == 24 && $level == 'A+') {
                        $ageFactor = 7;
                        $walkFactor = 7;
                        $strikeoutFactor = 3;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age == 25 && $level == 'A+') {
                        $ageFactor = 6;
                        $walkFactor = 6;
                        $strikeoutFactor = 4;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age >= 26 && $level == 'A+') {
                        $ageFactor = 5;
                        $walkFactor = 5;
                        $strikeoutFactor = 5;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    }

                    if ($age == 17 && $level == 'AA') {
                        $ageFactor = 16;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 16;
                        $hitFactor = 16;
                    } elseif ($age == 18 && $level == 'AA') {
                        $ageFactor = 15;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 15;
                        $hitFactor = 15;
                    } elseif ($age == 19 && $level == 'AA') {
                        $ageFactor = 14;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 14;
                        $hitFactor = 14;
                    } elseif ($age == 20 && $level == 'AA') {
                        $ageFactor = 13;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 13;
                        $hitFactor = 13;
                    } elseif ($age == 21 && $level == 'AA') {
                        $ageFactor = 12;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 12;
                        $hitFactor = 12;
                    } elseif ($age == 22 && $level == 'AA') {
                        $ageFactor = 11;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 11;
                        $hitFactor = 11;
                    } elseif ($age == 23 && $level == 'AA') {
                        $ageFactor = 10;
                        $walkFactor = 10;
                        $strikeoutFactor = 1;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age == 24 && $level == 'AA') {
                        $ageFactor = 9;
                        $walkFactor = 9;
                        $strikeoutFactor = 2;
                        $homerunFactor = 9;
                        $hitFactor = 9;
                    } elseif ($age == 25 && $level == 'AA') {
                        $ageFactor =8;
                        $walkFactor = 8;
                        $strikeoutFactor = 3;
                        $homerunFactor = 8;
                        $hitFactor = 8;
                    } elseif ($age >= 26 && $level == 'AA') {
                        $ageFactor = 7;
                        $walkFactor = 7;
                        $strikeoutFactor = 4;
                        $homerunFactor = 7;
                        $hitFactor = 7;
                    }

                    if ($age == 17 && $level == 'AAA') {
                        $ageFactor = 16;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 16;
                        $hitFactor = 16;
                    } elseif ($age == 18 && $level == 'AAA') {
                        $ageFactor = 15;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 15;
                        $hitFactor = 15;
                    } elseif ($age == 19 && $level == 'AAA') {
                        $ageFactor = 14;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 14;
                        $hitFactor = 14;
                    } elseif ($age == 20 && $level == 'AAA') {
                        $ageFactor = 13;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 13;
                        $hitFactor = 13;
                    } elseif ($age == 21 && $level == 'AAA') {
                        $ageFactor = 12;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 12;
                        $hitFactor = 12;
                    } elseif ($age == 22 && $level == 'AAA') {
                        $ageFactor = 11;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 11;
                        $hitFactor = 11;
                    } elseif ($age == 23 && $level == 'AAA') {
                        $ageFactor = 10;
                        $walkFactor = 10;
                        $strikeoutFactor = 0;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age == 24 && $level == 'AAA') {
                        $ageFactor = 10;
                        $walkFactor = 10;
                        $strikeoutFactor = 1;
                        $homerunFactor = 10;
                        $hitFactor = 9;
                    } elseif ($age == 25 && $level == 'AAA') {
                        $ageFactor = 9;
                        $walkFactor = 10;
                        $strikeoutFactor = 2;
                        $homerunFactor = 10;
                        $hitFactor = 10;
                    } elseif ($age >= 26 && $level == 'AAA') {
                        $ageFactor = 8;
                        $walkFactor = 9;
                        $strikeoutFactor = 3;
                        $homerunFactor = 9;
                        $hitFactor = 9;
                    }

                    if($atBats == 0) {
                        $atBats = 1;
                    }

                    if($plateAppearances == 0) {
                        $plateAppearances = 1;
                    }

                    if($strikeouts / $atBats >= .25 && $strikeoutFactor < 1 && $level == 'A') {
                        $strikeoutFactor = 2;
                    }

                    if($strikeouts / $atBats >= .25 && $strikeoutFactor < 1 && $level == 'A+') {
                        $strikeoutFactor = 2;
                    }

                    if($strikeouts / $atBats >= .25 && $strikeoutFactor < 1 && $level == 'AA') {
                        $strikeoutFactor = 1;
                    }

                    if($strikeouts / $atBats >= .25 && $strikeoutFactor < 1 && $level == 'AAA') {
                        $strikeoutFactor = 1;
                    }

                    $ageScore = (($age * $ageFactor) * $scaleFactor);
                    $battingScore = ((($homeruns * $homerunFactor) + ($triples * $hitFactor) + ($doubles * $hitFactor) + (($hits - $homeruns - $triples - $doubles) * $hitFactor)) / $atBats);
                    $walkScore = (($walks * $walkFactor) / $plateAppearances);
                    $strikeoutScore = (($strikeouts * $strikeoutFactor) / $plateAppearances);
                    $discpline = $walkScore - $strikeoutScore;
                    $seasonScore = $ageScore + $battingScore + $discpline - 3.5;


                    $playerFind = Player::where('name', $name)->first();
                    // dd($playerFind);
                    if($playerFind == null) {

                        $player = Player::create([
                        'name' => $name, 
                        'age' => $age,
                        'level' => $level, 
                        'plateAppearances' => $plateAppearances,
                        'atBats' => $atBats,
                        'hits' => $hits,
                        'doubles' => $doubles,
                        'triples' => $triples,
                        'homeruns' => $homeruns,
                        'walks' => $walks,
                        'strikeouts' => $strikeouts,
                        'seasonScore' => $seasonScore
                    ]);

                    } else {

                        $player = Player::where('name', $name)->update([
                        'age' => $age,
                        'level' => $level, 
                        'plateAppearances' => $plateAppearances,
                        'atBats' => $atBats,
                        'hits' => $hits,
                        'doubles' => $doubles,
                        'triples' => $triples,
                        'homeruns' => $homeruns,
                        'walks' => $walks,
                        'strikeouts' => $strikeouts,
                        'seasonScore' => $seasonScore
                        ]);
            }
        }
    }
}
