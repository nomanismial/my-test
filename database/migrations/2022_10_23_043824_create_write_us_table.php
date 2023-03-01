<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWriteUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('write_us', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->longText('meta_tags')->nullable();
            $table->longText('content')->nullable();
            $table->text('internal_links')->nullable();
            $table->text('microdata')->nullable();
            $table->text('category')->nullable();
            $table->integer('author')->nullable();
            $table->text('related')->nullable();
            $table->text('faqs')->nullable();
            $table->text('quotes')->nullable();
            $table->text('green_text')->nullable();
            $table->text('red_text')->nullable();
            $table->text('black_text')->nullable();
            $table->text('youtube_videos')->nullable();
            $table->text('facebook_videos')->nullable();
            $table->text('cover')->nullable();
            $table->text('og_image')->nullable();
            $table->text('buy_btn')->nullable();
            $table->enum('status',['publish','draft','trash'])->default('publish');
            $table->integer('date');
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
        Schema::dropIfExists('write_us');
    }
}
