<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
            $table->bigInteger('sport_id')->unsigned()->index();
            $table->foreign('sport_id')->references('id')->on('sports');
            $table->string('unique_id');
            $table->bigInteger('status');

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
        Schema::dropIfExists('leagues');
        Schema::enableForeignKeyConstraints();

    }
}
