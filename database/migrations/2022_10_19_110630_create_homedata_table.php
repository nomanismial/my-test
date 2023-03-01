<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomedataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homedata', function (Blueprint $table) {
            $table->id();
            $table->text('home_meta')->nullable();
            $table->text('home_slider')->nullable();
            $table->text('microdata')->nullable();
            $table->text('home_design')->nullable();
            $table->text('slider_images')->nullable();
            $table->text('footer')->nullable();
            $table->text('copyrights')->nullable();
            $table->text('social_links')->nullable();
            $table->integer('views')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homedata');
    }
}
