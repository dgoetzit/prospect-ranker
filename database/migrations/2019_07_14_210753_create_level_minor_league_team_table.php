<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelMinorLeagueTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_minor_league_team', function (Blueprint $table) {
            $table->integer('level_id');
            $table->integer('minor_league_team_id');
            $table->integer('year_id');
            $table->primary(['level_id', 'minor_league_team_id', 'year_id'], 'level_minor_year_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('level_minor_league');
    }
}
