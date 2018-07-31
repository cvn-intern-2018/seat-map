<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSeatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_seats', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('seat_map_id')->unsigned();
            $table->smallInteger('x');
            $table->smallInteger('y');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('seat_map_id')->references('id')->on('seat_maps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_seats', function (Blueprint $table) {
            Schema::dropIfExists('user_seats');
        });
    }
}
