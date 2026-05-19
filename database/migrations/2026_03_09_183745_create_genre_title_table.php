<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreTitleTable extends Migration
{
    public function up()
    {
        Schema::create('genre_title', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->foreignId('title_id')->constrained('titles')->cascadeOnDelete();
            $table->foreignId('genre_id')->constrained('genres')->cascadeOnDelete();
            $table->primary(['title_id', 'genre_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('genre_title');
    }
}
