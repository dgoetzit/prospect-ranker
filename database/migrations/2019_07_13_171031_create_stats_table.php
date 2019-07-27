<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('age');
            $table->integer('plateAppearances');
            $table->integer('atBats');
            $table->integer('hits');
            $table->integer('doubles');
            $table->integer('triples');
            $table->integer('homeruns');
            $table->integer('walks');
            $table->integer('strikeouts');
            $table->decimal('seasonScore');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stats');
    }
}
