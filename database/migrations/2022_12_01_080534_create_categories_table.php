<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->integer('tb_order')->nullable();
            $table->integer('home_popular')->nullable();
            $table->integer('before_popular')->nullable();
            $table->integer('after_popular')->nullable();
            $table->integer('popular_popular')->nullable();
            $table->text('home_title')->nullable();
            $table->text('before_title')->nullable();
            $table->text('after_title')->nullable();
            $table->text('popular_title')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('before_details')->nullable();
            $table->text('after_details')->nullable();
            $table->text('popular_details')->nullable();
            $table->text('meta_details')->nullable();
            $table->text('home_details')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_tags')->nullable();
            $table->string('microdata')->nullable();
            $table->string('og_image')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
