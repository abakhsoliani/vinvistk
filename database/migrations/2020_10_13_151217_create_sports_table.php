<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('name_en');
            $table->string('image');
            $table->integer('min_change');
            $table->integer('max_change');
            $table->float('premial_scale');
            $table->float('draw_scale');
            $table->integer('premial_score');
            $table->integer('max_point_difference');
            $table->integer('starting_point');
            $table->string('goal_name_en');
            $table->string('goal_name_ge');
            $table->integer('has_draw');//0no1yes



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

        Schema::dropIfExists('sports');
        Schema::enableForeignKeyConstraints();

    }
}
