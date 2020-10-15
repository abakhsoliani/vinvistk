<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('league_id')->unsigned()->index();
            $table->bigInteger('user_from_id')->unsigned()->index();
            $table->bigInteger('user_to_id')->unsigned()->index();
            $table->foreign('user_from_id')->references('id')->on('users');
            $table->foreign('user_to_id')->references('id')->on('users');
            $table->foreign('league_id')->references('id')->on('leagues');
            $table->integer('status');//0new1old
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('invitations');
        Schema::enableForeignKeyConstraints();

    }
}
