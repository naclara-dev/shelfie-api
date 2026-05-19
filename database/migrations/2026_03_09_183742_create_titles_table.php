<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitlesTable extends Migration
{
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->string('name');
            $table->foreignId('media_id')->constrained('media')->cascadeOnDelete();
            $table->string('year')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('titles');
    }
}
