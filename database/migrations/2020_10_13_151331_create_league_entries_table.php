<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeagueEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('league_entries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('league_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('league_id')->references('id')->on('leagues');
            $table->integer('played');
            $table->integer('win');
            $table->integer('loose');
            $table->integer('draw');
            $table->integer('goals_for');
            $table->integer('goals_against');
            $table->float('max_score');
            $table->float('min_score');
            $table->float('score');
        });
        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('league_entries');
        Schema::enableForeignKeyConstraints();

    }
}
