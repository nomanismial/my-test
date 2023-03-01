<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_tags')->nullable();
            $table->text('microdata')->nullable();
            $table->string('r_email')->nullable();
            $table->string('title')->nullable();
            $table->text('detail')->nullable();
            $table->string('email_title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_title')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_title')->nullable();
            $table->string('address')->nullable();
            $table->text('google_map')->nullable();
            $table->text('cover_image')->nullable();
            $table->text('og_image')->nullable();
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
        Schema::dropIfExists('contact_us');
    }
}
