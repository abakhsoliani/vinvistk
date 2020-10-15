<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('league_id')->unsigned()->index();
            $table->bigInteger('first_user_id')->unsigned()->index();
            $table->bigInteger('second_user_id')->unsigned()->index();
            $table->foreign('league_id')->references('id')->on('leagues');
            $table->foreign('first_user_id')->references('id')->on('users');
            $table->foreign('second_user_id')->references('id')->on('users');
            $table->integer('first_user_goals');
            $table->integer('second_user_goals');
            $table->float('second_user_score');
            $table->float('first_user_score');
            $table->float('second_user_old_score');
            $table->float('first_user_old_score');

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

        Schema::dropIfExists('matches');
        Schema::enableForeignKeyConstraints();

    }
}
