<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_books', function (Blueprint $table) {
            $table->id();
            $table->string('time')->nullabe();
            $table->string('browser')->nullabe();
            $table->string('ip')->nullabe();
            $table->string('city')->nullabe();
            $table->string('platform')->nullabe();
            $table->string('version')->nullabe();
            $table->string('device')->nullabe();
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
        Schema::dropIfExists('log_books');
    }
}
