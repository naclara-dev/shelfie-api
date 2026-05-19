<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration {
    public function up() {
        Schema::create('ratings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->id();
            $table->foreignId('title_id')->constrained('titles')->cascadeOnDelete();
            $table->decimal('rating', 3, 1);
            $table->string('comment');
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
        });
    }

    public function down() {
        Schema::dropIfExists('ratings');
    }
}
