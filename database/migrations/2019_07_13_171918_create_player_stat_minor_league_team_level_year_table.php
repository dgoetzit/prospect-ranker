<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerStatMinorLeagueTeamLevelYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_stat', function (Blueprint $table) {
            $table->bigInteger('player_id');
            $table->bigInteger('stat_id');
            $table->bigInteger('minor_league_team_id');
            $table->bigInteger('level_id');
            $table->bigInteger('year_id');
            $table->primary(['player_id', 'stat_id', 'minor_league_team_id', 'level_id', 'year_id'], 'player_stat_minor_level_year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_stat');
    }
}
