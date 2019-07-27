<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMinorLeagueTeamPlayerYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minor_league_team_player', function (Blueprint $table) {
            $table->integer('minor_league_team_id');
            $table->integer('player_id');
            $table->integer('year_id');
            $table->primary(['minor_league_team_id', 'player_id', 'year_id'], 'minor_player_year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('minor_league_team_player_year');
    }
}
