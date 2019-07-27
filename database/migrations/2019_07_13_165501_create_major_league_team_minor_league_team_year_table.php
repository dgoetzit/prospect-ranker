<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMajorLeagueTeamMinorLeagueTeamYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('major_league_team_minor_league_team', function (Blueprint $table) {
            $table->integer('major_league_team_id');
            $table->integer('minor_league_team_id');
            $table->integer('year_id');
            $table->primary(['major_league_team_id', 'minor_league_team_id', 'year_id'], 'major_minor_year_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('major_league_team_minor_league_team');
    }
}
