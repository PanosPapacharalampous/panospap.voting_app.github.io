<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Images extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->timestamps();
        });

        // this table-model is a pivot table and connect the model images with the users
        
        Schema::create('users_images', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('image_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('image_id')->references('id')->on('images');
        });

        //this model-table is a pivot table and connect the model images with category model

        Schema::create('categories_images', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('image_id')->unsigned();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('image_id')->references('id')->on('images');
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
