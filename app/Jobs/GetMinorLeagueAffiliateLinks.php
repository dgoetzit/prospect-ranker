<?php

namespace App\Jobs;

use App\Year;
use App\Level;
use App\ProfileLink;
use App\MajorLeagueTeam;
use App\MinorLeagueTeam;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetMinorLeagueAffiliateLinks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $majorLeagueTeam;
    public $year;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MajorLeagueTeam $majorLeagueTeam, Year $year)
    {
        $this->majorLeagueTeam = $majorLeagueTeam;
        $this->year = $year;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $affiliateTableURL = config('baseball_reference.affiliate_table_url');
        $teamAffiliateTableURL = $affiliateTableURL . $this->majorLeagueTeam->abbreviation;

        $html = file_get_contents($teamAffiliateTableURL);
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);

        $table = $dom->getElementByID('affiliates');
        $rows = $table->getElementsByTagName('tbody')->item(0)->getElementsByTagName('tr');

        for($i = 0; $i < $rows->length; $i++) {

            $yearRows = $rows[$i]->getElementsByTagName("th");
            $parsedYear = $yearRows->item(0)->textContent;
            $parsedYear = explode(' ', $parsedYear);
            $parsedYear = $parsedYear[0];
            $teamRows = $rows[$i]->getElementsByTagName("td");

            
            if($parsedYear == $this->year->year) {
                Log::debug('Parsed Year: '.$parsedYear);
                Log::debug('This Year: '.$this->year->year);
                $aaa = $teamRows->item(0)->textContent;

                foreach($teamRows as $key => $teamRow) {
                    $a = $teamRow->getElementsByTagName('a');
                    $teamLevel = $teamRow->getAttribute('data-stat');
                    foreach($a as $row) {
                        $href = $row->getAttribute('href');
                        $dataTip = $row->getAttribute('data-tip');
                        $explodedDataTip = explode(',', $dataTip);
                        $team = $explodedDataTip[0];
                        Log::debug($team);

                        // So, at this point
                        // I should create records

                        $minorLeagueTeamExists = MinorLeagueTeam::where('name', $team)->first();
                        if($minorLeagueTeamExists) {
                            $minorLeagueTeam = $minorLeagueTeamExists;
                        } else {
                            $minorLeagueTeam = new MinorLeagueTeam;
                            $minorLeagueTeam->name = $team;
                            $minorLeagueTeam->save();
                        }
                        
                        $year_id = ['year_id' => $this->year->id];

                        // Then I want to create a relationship between the minor league team
                        // And the major league team
                        $this->majorLeagueTeam->minorLeagueTeams()->attach($minorLeagueTeam, $year_id);

                        // Then I want to create a relationship between the minor league team
                        // And the level
                        $level = Level::where('name', $teamLevel)->first();
                        $minorLeagueTeam->levels()->attach($level, $year_id);

                        $profileLink = new ProfileLink;
                        $profileLink->link = $href;
                        $profileLink->save();

                        $minorLeagueTeam->profileLinks()->attach($profileLink, $year_id);
                        // I do this because I only want to get the top 4 levels of minor league affiliates, may expand later
                        if($key == 3) {
                            return;
                        }
                    }
                }
                return;
            }
        }
        Log::debug($teamAffiliateTableURL);
    }
}
