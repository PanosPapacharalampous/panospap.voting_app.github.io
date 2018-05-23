<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesVotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('voter_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('voter_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('votes');
        Schema::drop('categories');
    }


}
