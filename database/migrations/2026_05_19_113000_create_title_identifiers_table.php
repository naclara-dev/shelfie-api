<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitleIdentifiersTable extends Migration
{
    public function up()
    {
        Schema::create('title_identifiers', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->foreignId('title_id')->constrained('titles')->cascadeOnDelete();
            $table->foreignId('source_id')->constrained('sources')->cascadeOnDelete();
            $table->string('value');
            $table->timestamps();

            $table->unique(['source_id', 'value']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('title_identifiers');
    }
}
