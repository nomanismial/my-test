<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->longText('meta_tags')->nullable();
            $table->longText('content')->nullable();
            $table->text('internal_links')->nullable();
            $table->text('microdata')->nullable();
            $table->text('category_id')->nullable();
            $table->integer('author_id')->nullable();
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
            $table->integer('date')->nullable();
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
        Schema::dropIfExists('blogs');
    }
}
