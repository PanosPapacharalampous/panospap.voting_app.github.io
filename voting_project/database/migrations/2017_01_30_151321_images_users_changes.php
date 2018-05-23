<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImagesUsersChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->default(1);
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('profile_image_id')->unsigned()->nullable();
            $table->foreign('profile_image_id')->references('id')->on('images');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
