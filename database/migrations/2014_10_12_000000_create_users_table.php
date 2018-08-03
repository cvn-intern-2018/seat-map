<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable()->default(null);
            $table->string('password', 255);
            $table->integer('user_group_id')->unsigned()->nullable()->default(1);
            $table->string('email', 100)->unique()->nullable()->default(null);
            $table->tinyInteger('permission')->default(0);
            $table->string('username', 100)->unique();
            $table->string('short_name', 100);
            $table->string('phone', 15)->nullable();
            $table->string('img', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
