<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Player;

class PlayerController extends Controller
{
    
    public function index() {

                Player::truncate();

                $htmlFiles = array();
                array_push($htmlFiles, 'https://www.baseball-reference.com/register/team.cgi?id=41270199'); // single a
                array_push($htmlFiles, 'https://www.baseball-reference.com/register/team.cgi?id=299f8366'); // high a
                array_push($htmlFiles, 'https://www.baseball-reference.com/register/team.cgi?id=77bbc259'); // double a
                array_push($htmlFiles, 'https://www.baseball-reference.com/register/team.cgi?id=a9a73fdc'); // triple a

                foreach ($htmlFiles as $html) {

                    if (strpos($html, '41270199') !== false) {
                        $level = 'A';
                    } elseif (strpos($html, '299f8366') !== false) {
                        $level = 'A+';
                    } elseif (strpos($html, '77bbc259') !== false) {
                        $level = 'AA';
                    } elseif (strpos($html, 'a9a73fdc') !== false) {
                        $level = 'AAA';
                    }
                    
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

    	$players = Player::where('atBats', '>=', 100)->orderBy('seasonScore', 'desc')->get();

    	return view('players.index', compact('players'));
    } // end index

    public function indexTest() {

                Player::truncate();

                $htmlFiles = array();

                // using 2015 data from multiple teams and levels

                // single A
                array_push($htmlFiles, 'https://www.baseball-reference.com/register/team.cgi?id=41270199', 'https://www.baseball-reference.com/register/team.cgi?id=55c5d8d8', 'https://www.baseball-reference.com/register/team.cgi?id=29d7ad0c', 'https://www.baseball-reference.com/register/team.cgi?id=405cf259');
                // high A
                array_push($htmlFiles, 'https://www.baseball-reference.com/register/team.cgi?id=299f8366', 'https://www.baseball-reference.com/register/team.cgi?id=e22c562d', 'https://www.baseball-reference.com/register/team.cgi?id=516b0a8c', 'https://www.baseball-reference.com/register/team.cgi?id=af75a842');
                //  double A
                array_push($htmlFiles, 'https://www.baseball-reference.com/register/team.cgi?id=77bbc259', 'https://www.baseball-reference.com/register/team.cgi?id=f0504ef5', 'https://www.baseball-reference.com/register/team.cgi?id=600a4bdc', 'https://www.baseball-reference.com/register/team.cgi?id=92b03399', 'https://www.baseball-reference.com/register/team.cgi?id=56f34557', 'https://www.baseball-reference.com/register/team.cgi?id=ef66e764', 'https://www.baseball-reference.com/register/team.cgi?id=cf523a0e');
                // triple A
                array_push($htmlFiles, 'https://www.baseball-reference.com/register/team.cgi?id=6f6f655d', 'https://www.baseball-reference.com/register/team.cgi?id=ece1a071', 'https://www.baseball-reference.com/register/team.cgi?id=8aa8d3f5', 'https://www.baseball-reference.com/register/team.cgi?id=1d437da9', 'https://www.baseball-reference.com/register/team.cgi?id=8fc88abe');

                foreach ($htmlFiles as $html) {

                    if (strpos($html, '41270199') || strpos($html, '55c5d8d8') || strpos($html, '29d7ad0c') || strpos($html, '405cf259') !== false) {
                        $level = 'A';
                    } elseif (strpos($html, '299f8366') || strpos($html, 'e22c562d') || strpos($html, '516b0a8c') || strpos($html, 'af75a842') !== false) {
                        $level = 'A+';
                    } elseif (strpos($html, '77bbc259') || strpos($html, 'f0504ef5') || strpos($html, '600a4bdc') || strpos($html, '92b03399') || strpos($html, '56f34557') || strpos($html, 'ef66e764') || strpos($html, 'cf523a0e') !== false) {
                        $level = 'AA';
                    } elseif (strpos($html, '6f6f655d') || strpos($html, 'ece1a071') || strpos($html, '8aa8d3f5') || strpos($html, '1d437da9') || strpos($html, '8fc88abe') !== false) {
                        $level = 'AAA';
                    }
                    
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
                            $ageFactor = 8;
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
                            $ageFactor = 9;
                            $walkFactor = 10;
                            $strikeoutFactor = 1;
                            $homerunFactor = 10;
                            $hitFactor = 10;
                        } elseif ($age == 25 && $level == 'AAA') {
                            $ageFactor = 8;
                            $walkFactor = 10;
                            $strikeoutFactor = 2;
                            $homerunFactor = 10;
                            $hitFactor = 10;
                        } elseif ($age >= 26 && $level == 'AAA') {
                            $ageFactor = 7;
                            $walkFactor = 10;
                            $strikeoutFactor = 3;
                            $homerunFactor = 10;
                            $hitFactor = 10;
                        }

                        if($atBats == 0) {
                            $atBats = 1;
                        }

                        if($plateAppearances == 0) {
                            $plateAppearances = 1;
                        }

                        if($strikeouts / $atBats >= .25 && $strikeoutFactor < 1 && $level == 'A' && $age >= 21) {
                            $strikeoutFactor = 1;
                        }

                        if($strikeouts / $atBats >= .25 && $strikeoutFactor < 1 && $level == 'A+' && $age >= 22) {
                            $strikeoutFactor = 2;
                        }

                        if($strikeouts / $atBats >= .25 && $strikeoutFactor < 1 && $level == 'AA' && $age >= 23) {
                            $strikeoutFactor = 1;
                        }

                        if($strikeouts / $atBats >= .25 && $strikeoutFactor < 1 && $level == 'AAA' && $age >= 24) {
                            $strikeoutFactor = 1;
                        }

                        $ageScore = (($age * $ageFactor) * $scaleFactor);
                        $battingScore = ((($homeruns * $homerunFactor) + ($triples * $hitFactor) + ($doubles * $hitFactor) + (($hits - $homeruns - $triples - $doubles) * $hitFactor)) / $atBats);
                        $walkScore = (($walks * $walkFactor) / $plateAppearances);
                        $strikeoutScore = (($strikeouts * $strikeoutFactor) / $plateAppearances);
                        $discpline = $walkScore - $strikeoutScore;
                        $seasonScore = $ageScore + $battingScore + $discpline - 3.5;

                        // $seasonScore = (($age * $ageFactor) * $scaleFactor) + ((($homeruns * $homerunFactor) + $triples + $doubles + ($hits - $homeruns - $triples - $doubles)) / $atBats) + (($walks * $walkFactor) / $plateAppearances) - (($strikeouts * $strikeoutFactor) / $plateAppearances);


                        $playerFind = Player::where('name', $name)->first();
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

        $players = Player::where('atBats', '>=', 250)->orderBy('seasonScore', 'desc')->get();

        return view('players.test', compact('players'));
    } // end index test

    public function createA() {

        Player::truncate();

        $dom = new \DOMDocument();
		// $html = file_get_contents('https://www.baseball-reference.com/register/team.cgi?id=41270199'); // Current Cubs A
        $html = file_get_contents('https://www.baseball-reference.com/register/team.cgi?id=27a3a5f5'); // Old Cubs A
		libxml_use_internal_errors(true);
		$dom->loadHTML($html);

		$table = $dom->getElementByID('team_batting');

		$rows = $table->getElementsByTagName("tbody")->item(0)->getElementsByTagName("tr");

		$playerList = array();

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
		    $level = 'A';

		    if ($age == 17 && $level == 'A') {
		        $ageFactor = 10;
		        $walkFactor = 10;
		        $strikeoutFactor = 1;
		        $homerunFactor = 10;
                $hitFactor = 10;
		    } elseif ($age == 18 && $level == 'A') {
		        $ageFactor = 10;
		        $walkFactor = 10;
		        $strikeoutFactor = 1;
		        $homerunFactor = 10;
                $hitFactor = 10;
		    } elseif ($age == 19 && $level == 'A') {
		        $ageFactor = 10;
		        $walkFactor = 10;
		        $strikeoutFactor = 1;
		        $homerunFactor = 10;
                $hitFactor = 10;
		    } elseif ($age == 20 && $level == 'A') {
		        $ageFactor = 9;
		        $walkFactor = 10;
		        $strikeoutFactor = 2;
		        $homerunFactor = 10;
                $hitFactor = 10;
		    } elseif ($age == 21 && $level == 'A') {
		        $ageFactor = 8;
		        $walkFactor = 10;
		        $strikeoutFactor = 3;
		        $homerunFactor = 10;
                $hitFactor = 10;
		    } elseif ($age == 22 && $level == 'A') {
		        $ageFactor = 7;
		        $walkFactor = 8;
		        $strikeoutFactor = 4;
		        $homerunFactor = 8;
                $hitFactor = 8;
		    } elseif ($age == 23 && $level == 'A') {
		        $ageFactor = 6;
		        $walkFactor = 6;
		        $strikeoutFactor = 5;
		        $homerunFactor = 7;
                $hitFactor = 7;
		    } elseif ($age == 24 && $level == 'A') {
		        $ageFactor = 5;
		        $walkFactor = 4;
		        $strikeoutFactor = 6;
		        $homerunFactor = 6;
                $hitFactor = 6;
		    } elseif ($age == 25 && $level == 'A') {
		        $ageFactor = 4;
		        $walkFactor = 2;
		        $strikeoutFactor = 7;
		        $homerunFactor = 5;
                $hitFactor = 5;
		    } elseif ($age >= 26 && $level == 'A') {
                $ageFactor = 3;
                $walkFactor = 2;
                $strikeoutFactor = 8;
                $homerunFactor = 4;
                $hitFactor = 4;
            }

		    if($atBats == 0) {
    		    	$atBats = 1;
    		    }

		    $ageScore = (($age * $ageFactor) * $scaleFactor);
            $battingScore = ((($homeruns * $homerunFactor) + ($triples * $hitFactor) + ($doubles * $hitFactor) + (($hits - $homeruns - $triples - $doubles) * $hitFactor)) / $atBats);
            $walkScore = (($walks * $walkFactor) / $plateAppearances);
            $strikeoutScore = (($strikeouts * $strikeoutFactor) / $plateAppearances);
            $discpline = $walkScore - $strikeoutScore;

            // $seasonScore = (($age * $ageFactor) * $scaleFactor) + ((($homeruns * $homerunFactor) + $triples + $doubles + ($hits - $homeruns - $triples - $doubles)) / $atBats) + (($walks * $walkFactor) / $plateAppearances) - (($strikeouts * $strikeoutFactor) / $plateAppearances);

            $seasonScore = $ageScore + $battingScore + $discpline - 2.5;


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

		}
    	return view('players.a');
    } // end create A

    public function createHighA() {

        $dom = new \DOMDocument();
		$html = file_get_contents('https://www.baseball-reference.com/register/team.cgi?id=299f8366');
		libxml_use_internal_errors(true);
		$dom->loadHTML($html);

		$table = $dom->getElementByID('team_batting');

		$rows = $table->getElementsByTagName("tbody")->item(0)->getElementsByTagName("tr");

		$playerList = array();

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
		    $level = 'A+';

		    if ($age == 17 && $level == 'A+') {
		        $ageFactor = 10;
		        $walkFactor = 10;
		        $strikeoutFactor = 2;
		        $homerunFactor = 10;
		    } elseif ($age == 18 && $level == 'A+') {
		        $ageFactor = 10;
		        $walkFactor = 10;
		        $strikeoutFactor = 2;
		        $homerunFactor = 10;
		    } elseif ($age == 19 && $level == 'A+') {
		        $ageFactor = 10;
		        $walkFactor = 10;
		        $strikeoutFactor = 2;
		        $homerunFactor = 10;
		    } elseif ($age == 20 && $level == 'A+') {
		        $ageFactor = 10;
		        $walkFactor = 10;
		        $strikeoutFactor = 2;
		        $homerunFactor = 10;
		    } elseif ($age == 21 && $level == 'A+') {
		        $ageFactor = 8;
		        $walkFactor = 10;
		        $strikeoutFactor = 2;
		        $homerunFactor = 10;
		    } elseif ($age == 22 && $level == 'A+') {
		        $ageFactor = 6;
		        $walkFactor = 8;
		        $strikeoutFactor = 4;
		        $homerunFactor = 8;
		    } elseif ($age == 23 && $level == 'A+') {
		        $ageFactor = 4;
		        $walkFactor = 6;
		        $strikeoutFactor = 6;
		        $homerunFactor = 6;
		    } elseif ($age == 24 && $level == 'A+') {
		        $ageFactor = 2;
		        $walkFactor = 4;
		        $strikeoutFactor = 8;
		        $homerunFactor = 4;
		    } elseif ($age == 25 && $level == 'A+') {
		        $ageFactor = 0;
		        $walkFactor = 2;
		        $strikeoutFactor = 10;
		        $homerunFactor = 2;
		    }

		    if($atBats == 0) {
    		    	$atBats = 1;
    		    }

		    $seasonScore = (($age * $ageFactor) * $scaleFactor) + ((($homeruns * $homerunFactor) + $triples + $doubles + ($hits - $homeruns - $triples - $doubles)) / $atBats) + (($walks * $walkFactor) / $plateAppearances) - (($strikeouts * $strikeoutFactor) / $plateAppearances);


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

		}
    	return view('players.higha');
    } // end create A+

    public function createAA() {

            $dom = new \DOMDocument();
    		$html = file_get_contents('https://www.baseball-reference.com/register/team.cgi?id=77bbc259');
    		libxml_use_internal_errors(true);
    		$dom->loadHTML($html);

    		$table = $dom->getElementByID('team_batting');

    		$rows = $table->getElementsByTagName("tbody")->item(0)->getElementsByTagName("tr");

    		$playerList = array();

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
    		    $level = 'AA';

    		    if ($age == 17 && $level == 'AA') {
    		        $ageFactor = 10;
    		        $walkFactor = 10;
    		        $strikeoutFactor = 2;
    		        $homerunFactor = 10;
    		    } elseif ($age == 18 && $level == 'AA') {
    		        $ageFactor = 10;
    		        $walkFactor = 10;
    		        $strikeoutFactor = 2;
    		        $homerunFactor = 10;
    		    } elseif ($age == 19 && $level == 'AA') {
    		        $ageFactor = 10;
    		        $walkFactor = 10;
    		        $strikeoutFactor = 2;
    		        $homerunFactor = 10;
    		    } elseif ($age == 20 && $level == 'AA') {
    		        $ageFactor = 10;
    		        $walkFactor = 10;
    		        $strikeoutFactor = 2;
    		        $homerunFactor = 10;
    		    } elseif ($age == 21 && $level == 'AA') {
    		        $ageFactor = 8;
    		        $walkFactor = 10;
    		        $strikeoutFactor = 2;
    		        $homerunFactor = 10;
    		    } elseif ($age == 22 && $level == 'AA') {
    		        $ageFactor = 6;
    		        $walkFactor = 8;
    		        $strikeoutFactor = 4;
    		        $homerunFactor = 8;
    		    } elseif ($age == 23 && $level == 'AA') {
    		        $ageFactor = 4;
    		        $walkFactor = 6;
    		        $strikeoutFactor = 6;
    		        $homerunFactor = 6;
    		    } elseif ($age == 24 && $level == 'AA') {
    		        $ageFactor = 4;
    		        $walkFactor = 6;
    		        $strikeoutFactor = 6;
    		        $homerunFactor = 6;
    		    } elseif ($age == 25 && $level == 'AA') {
    		        $ageFactor = 0;
    		        $walkFactor = 2;
    		        $strikeoutFactor = 10;
    		        $homerunFactor = 2;
    		    }

    		    if($atBats == 0) {
    		    	$atBats = 1;
    		    }

    		    $seasonScore = (($age * $ageFactor) * $scaleFactor) + ((($homeruns * $homerunFactor) + $triples + $doubles + ($hits - $homeruns - $triples - $doubles)) / $atBats) + (($walks * $walkFactor) / $plateAppearances) - (($strikeouts * $strikeoutFactor) / $plateAppearances);

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

    		}
        	return view('players.aa');
        } // end create AA

        public function createAAA() {

            $dom = new \DOMDocument();
    		$html = file_get_contents('https://www.baseball-reference.com/register/team.cgi?id=a9a73fdc');
    		libxml_use_internal_errors(true);
    		$dom->loadHTML($html);

    		$table = $dom->getElementByID('team_batting');

    		$rows = $table->getElementsByTagName("tbody")->item(0)->getElementsByTagName("tr");

    		$playerList = array();

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
    		    $level = 'AAA';

    		    if ($age == 17 && $level == 'AAA') {
    		        $ageFactor = 10;
    		        $walkFactor = 10;
    		        $strikeoutFactor = 2;
    		        $homerunFactor = 10;
    		    } elseif ($age == 18 && $level == 'AAA') {
    		        $ageFactor = 10;
    		        $walkFactor = 10;
    		        $strikeoutFactor = 2;
    		        $homerunFactor = 10;
    		    } elseif ($age == 19 && $level == 'AAA') {
    		        $ageFactor = 10;
    		        $walkFactor = 10;
    		        $strikeoutFactor = 2;
    		        $homerunFactor = 10;
    		    } elseif ($age == 20 && $level == 'AAA') {
    		        $ageFactor = 10;
    		        $walkFactor = 10;
    		        $strikeoutFactor = 2;
    		        $homerunFactor = 10;
    		    } elseif ($age == 21 && $level == 'AAA') {
    		        $ageFactor = 8;
    		        $walkFactor = 10;
    		        $strikeoutFactor = 2;
    		        $homerunFactor = 10;
    		    } elseif ($age == 22 && $level == 'AAA') {
    		        $ageFactor = 6;
    		        $walkFactor = 8;
    		        $strikeoutFactor = 4;
    		        $homerunFactor = 8;
    		    } elseif ($age == 23 && $level == 'AAA') {
    		        $ageFactor = 4;
    		        $walkFactor = 6;
    		        $strikeoutFactor = 6;
    		        $homerunFactor = 6;
    		    } elseif ($age == 24 && $level == 'AAA') {
    		        $ageFactor = 2;
    		        $walkFactor = 4;
    		        $strikeoutFactor = 8;
    		        $homerunFactor = 4;
    		    } elseif ($age == 25 && $level == 'AAA') {
    		        $ageFactor = 0;
    		        $walkFactor = 2;
    		        $strikeoutFactor = 10;
    		        $homerunFactor = 2;
    		    } elseif ($age > 26 && $level == 'AAA') {
    		        $ageFactor = 0;
    		        $walkFactor = 1;
    		        $strikeoutFactor = 10;
    		        $homerunFactor = 1;
    		    }

    		    if($atBats == 0) {
    		    	$atBats = 1;
    		    }

    		    $seasonScore = (($age * $ageFactor) * $scaleFactor) + ((($homeruns * $homerunFactor) + $triples + $doubles + ($hits - $homeruns - $triples - $doubles)) / $atBats) + (($walks * $walkFactor) / $plateAppearances) - (($strikeouts * $strikeoutFactor) / $plateAppearances);


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

    		}
        	return view('players.aaa');
        } // end create AAA


} // end file
