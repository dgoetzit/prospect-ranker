<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMinorLeagueTeamProfileLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minor_league_team_profile_link', function (Blueprint $table) {
            $table->integer('minor_league_team_id');
            $table->integer('profile_link_id');
            $table->integer('year_id');
            $table->primary(['minor_league_team_id', 'profile_link_id', 'year_id'], 'minor_link_year_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('minor_league_team_profile_link');
    }
}
