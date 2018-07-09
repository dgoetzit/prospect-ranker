<?php

use App\Player;

$dom = new DOMDocument();
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
    $level = 'AA';

    if ($age == 17 && $level == 'A') {
        $ageFactor = 10;
        $walkFactor = 10;
        $strikeoutFactor = 2;
        $homerunFactor = 10;
        $hitFactor = 10;
    } elseif ($age == 18 && $level == 'A') {
        $ageFactor = 9;
        $walkFactor = 10;
        $strikeoutFactor = 2;
        $homerunFactor = 10;
        $hitFactor = 9;
    } elseif ($age == 19 && $level == 'A') {
        $ageFactor = 8;
        $walkFactor = 10;
        $strikeoutFactor = 2;
        $homerunFactor = 10;
        $hitFactor = 8;
    } elseif ($age == 20 && $level == 'A') {
        $ageFactor = 7;
        $walkFactor = 10;
        $strikeoutFactor = 2;
        $homerunFactor = 10;
        $hitFactor = 7;
    } elseif ($age == 21 && $level == 'A') {
        $ageFactor = 6;
        $walkFactor = 10;
        $strikeoutFactor = 2;
        $homerunFactor = 10;
        $hitFactor = 6;
    } elseif ($age == 22 && $level == 'A') {
        $ageFactor = 5;
        $walkFactor = 9;
        $strikeoutFactor = 3;
        $homerunFactor = 8;
        $hitFactor = 5;
    } elseif ($age == 23 && $level == 'A') {
        $ageFactor = 4;
        $walkFactor = 8;
        $strikeoutFactor = 4;
        $homerunFactor = 6;
        $hitFactor = 4;
    } elseif ($age == 24 && $level == 'A') {
        $ageFactor = 3;
        $walkFactor = 7;
        $strikeoutFactor = 5;
        $homerunFactor = 4;
        $hitFactor = 3;
    } elseif ($age == 25 && $level == 'A') {
        $ageFactor = 2;
        $walkFactor = 6;
        $strikeoutFactor = 6;
        $homerunFactor = 2;
        $hitFactor = 2;
    } elseif ($age >= 26 && $level == 'A') {
        $ageFactor = 0;
        $walkFactor = 5;
        $strikeoutFactor = 7;
        $homerunFactor = 2;
        $hitFactor = 2;
    }

    if ($age == 17 && $level == 'AA') {
        $ageFactor = 10;
        $walkFactor = 10;
        $strikeoutFactor = 1;
        $homerunFactor = 10;
        $hitFactor = 10;
    } elseif ($age == 18 && $level == 'AA') {
        $ageFactor = 10;
        $walkFactor = 10;
        $strikeoutFactor = 1;
        $homerunFactor = 10;
        $hitFactor = 10;
    } elseif ($age == 19 && $level == 'AA') {
        $ageFactor = 10;
        $walkFactor = 10;
        $strikeoutFactor = 2;
        $homerunFactor = 10;
        $hitFactor = 10;
    } elseif ($age == 20 && $level == 'AA') {
        $ageFactor = 10;
        $walkFactor = 10;
        $strikeoutFactor = 2;
        $homerunFactor = 10;
        $hitFactor = 10;
    } elseif ($age == 21 && $level == 'AA') {
        $ageFactor = 9;
        $walkFactor = 10;
        $strikeoutFactor = 2;
        $homerunFactor = 10;
        $hitFactor = 9;
    } elseif ($age == 22 && $level == 'AA') {
        $ageFactor = 8;
        $walkFactor = 9;
        $strikeoutFactor = 3;
        $homerunFactor = 9;
        $hitFactor = 8;
    } elseif ($age == 23 && $level == 'AA') {
        $ageFactor = 7;
        $walkFactor = 8;
        $strikeoutFactor = 4;
        $homerunFactor = 8;
        $hitFactor = 7;
    } elseif ($age == 24 && $level == 'AA') {
        $ageFactor = 6;
        $walkFactor = 7;
        $strikeoutFactor = 5;
        $homerunFactor = 7;
        $hitFactor = 6;
    } elseif ($age == 25 && $level == 'AA') {
        $ageFactor = 5;
        $walkFactor = 6;
        $strikeoutFactor = 6;
        $homerunFactor = 6;
        $hitFactor = 5;
    } elseif ($age >= 26 && $level == 'AA') {
        $ageFactor = 4;
        $walkFactor = 5;
        $strikeoutFactor = 7;
        $homerunFactor = 5;
        $hitFactor = 4;
    }

    $ageScore = (($age * $ageFactor) * $scaleFactor);
    $battingScore = ((($homeruns * $homerunFactor) + ($triples * $hitFactor) + ($doubles * $hitFactor) + (($hits - $homeruns - $triples - $doubles) * $hitFactor)) / $atBats);
    $walkScore = (($walks * $walkFactor) / $plateAppearances);
    $strikeoutScore = (($strikeouts * $strikeoutFactor) / $plateAppearances);
    $discpline = $walkScore - $strikeoutScore;

    $seasonScore = $ageScore + $battingScore + $discpline - 2;


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

    if($atBats < 100) {
        $seasonScore = 0;
        $ageScore = 0;
        $battingScore = 0;
        $walkScore = 0;
        $strikeoutScore = 0;
        $discpline = 0;
    }


        // echo $name . ': '. number_format((float)$seasonScore, 2, '.', '');
        // echo '<br>';

        echo $name . ': ' . number_format((float)$seasonScore, 2, '.', '');
        echo '<br>';

    

    // foreach($players as $player){
    //     echo $player->name . ': ' . $player->seasonScore;
    //     echo '<br>';
    // }

}


?>

<h1>Welcome</h1>
<a href="/players">View Cubs Prospect Rankings</a>


<?

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
    $walkFactor = 9;
    $strikeoutFactor = 2;
    $homerunFactor = 9;
    $hitFactor = 9;
} elseif ($age == 21 && $level == 'A') {
    $ageFactor = 8;
    $walkFactor = 8;
    $strikeoutFactor = 2;
    $homerunFactor = 8;
    $hitFactor = 8;
} elseif ($age == 22 && $level == 'A') {
    $ageFactor = 7;
    $walkFactor = 7;
    $strikeoutFactor = 3;
    $homerunFactor = 7;
    $hitFactor = 7;
} elseif ($age == 23 && $level == 'A') {
    $ageFactor = 6;
    $walkFactor = 6;
    $strikeoutFactor = 4;
    $homerunFactor = 6;
    $hitFactor = 6;
} elseif ($age == 24 && $level == 'A') {
    $ageFactor = 6;
    $walkFactor = 5;
    $strikeoutFactor = 5;
    $homerunFactor = 5;
    $hitFactor = 5;
} elseif ($age == 25 && $level == 'A') {
    $ageFactor = 4;
    $walkFactor = 4;
    $strikeoutFactor = 6;
    $homerunFactor = 4;
    $hitFactor = 4;
} elseif ($age >= 26 && $level == 'A') {
    $ageFactor = 3;
    $walkFactor = 3;
    $strikeoutFactor = 7;
    $homerunFactor = 3;
    $hitFactor = 3;
}

if ($age == 17 && $level == 'A+') {
    $ageFactor = 10;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 10;
} elseif ($age == 18 && $level == 'A+') {
    $ageFactor = 9;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 9;
} elseif ($age == 19 && $level == 'A+') {
    $ageFactor = 8;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 8;
} elseif ($age == 20 && $level == 'A+') {
    $ageFactor = 7;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 7;
} elseif ($age == 21 && $level == 'A+') {
    $ageFactor = 6;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 6;
} elseif ($age == 22 && $level == 'A+') {
    $ageFactor = 5;
    $walkFactor = 9;
    $strikeoutFactor = 3;
    $homerunFactor = 8;
    $hitFactor = 5;
} elseif ($age == 23 && $level == 'A+') {
    $ageFactor = 4;
    $walkFactor = 8;
    $strikeoutFactor = 4;
    $homerunFactor = 6;
    $hitFactor = 4;
} elseif ($age == 24 && $level == 'A+') {
    $ageFactor = 3;
    $walkFactor = 7;
    $strikeoutFactor = 5;
    $homerunFactor = 4;
    $hitFactor = 3;
} elseif ($age == 25 && $level == 'A+') {
    $ageFactor = 2;
    $walkFactor = 6;
    $strikeoutFactor = 6;
    $homerunFactor = 2;
    $hitFactor = 2;
} elseif ($age >= 26 && $level == 'A+') {
    $ageFactor = 0;
    $walkFactor = 5;
    $strikeoutFactor = 7;
    $homerunFactor = 2;
    $hitFactor = 2;
}

if ($age == 17 && $level == 'AA') {
    $ageFactor = 10;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 10;
} elseif ($age == 18 && $level == 'AA') {
    $ageFactor = 9;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 9;
} elseif ($age == 19 && $level == 'AA') {
    $ageFactor = 8;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 8;
} elseif ($age == 20 && $level == 'AA') {
    $ageFactor = 7;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 7;
} elseif ($age == 21 && $level == 'AA') {
    $ageFactor = 6;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 6;
} elseif ($age == 22 && $level == 'AA') {
    $ageFactor = 5;
    $walkFactor = 9;
    $strikeoutFactor = 3;
    $homerunFactor = 8;
    $hitFactor = 5;
} elseif ($age == 23 && $level == 'AA') {
    $ageFactor = 4;
    $walkFactor = 8;
    $strikeoutFactor = 4;
    $homerunFactor = 6;
    $hitFactor = 4;
} elseif ($age == 24 && $level == 'AA') {
    $ageFactor = 3;
    $walkFactor = 7;
    $strikeoutFactor = 5;
    $homerunFactor = 4;
    $hitFactor = 3;
} elseif ($age == 25 && $level == 'AA') {
    $ageFactor = 2;
    $walkFactor = 6;
    $strikeoutFactor = 6;
    $homerunFactor = 2;
    $hitFactor = 2;
} elseif ($age >= 26 && $level == 'AA') {
    $ageFactor = 0;
    $walkFactor = 5;
    $strikeoutFactor = 7;
    $homerunFactor = 2;
    $hitFactor = 2;
}

if ($age == 17 && $level == 'AAA') {
    $ageFactor = 10;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 10;
} elseif ($age == 18 && $level == 'AAA') {
    $ageFactor = 10;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 10;
} elseif ($age == 19 && $level == 'AAA') {
    $ageFactor = 10;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 10;
} elseif ($age == 20 && $level == 'AAA') {
    $ageFactor = 10;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 10;
} elseif ($age == 21 && $level == 'AAA') {
    $ageFactor = 10;
    $walkFactor = 10;
    $strikeoutFactor = 2;
    $homerunFactor = 10;
    $hitFactor = 10;
} elseif ($age == 22 && $level == 'AAA') {
    $ageFactor = 9;
    $walkFactor = 9;
    $strikeoutFactor = 3;
    $homerunFactor = 8;
    $hitFactor = 9;
} elseif ($age == 23 && $level == 'AAA') {
    $ageFactor = 8;
    $walkFactor = 8;
    $strikeoutFactor = 4;
    $homerunFactor = 6;
    $hitFactor = 8;
} elseif ($age == 24 && $level == 'AAA') {
    $ageFactor = 7;
    $walkFactor = 7;
    $strikeoutFactor = 5;
    $homerunFactor = 4;
    $hitFactor = 7;
} elseif ($age == 25 && $level == 'AAA') {
    $ageFactor = 6;
    $walkFactor = 6;
    $strikeoutFactor = 6;
    $homerunFactor = 2;
    $hitFactor = 6;
} elseif ($age >= 26 && $level == 'AAA') {
    $ageFactor = 5;
    $walkFactor = 5;
    $strikeoutFactor = 7;
    $homerunFactor = 2;
    $hitFactor = 5;
}
?>

