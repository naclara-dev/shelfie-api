<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->string('name')->unique();
            $table->foreignId('media_id')->constrained('media')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sources');
    }
}
