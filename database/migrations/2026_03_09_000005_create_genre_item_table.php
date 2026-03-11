<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreItemTable extends Migration {
    public function up() {
        Schema::create('genre_item', function (Blueprint $table) {            
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('genre_id')->constrained('genres')->cascadeOnDelete();
            $table->primary(['item_id', 'genre_id']);
        });
    }

    public function down() {
        Schema::dropIfExists('genre_item');
    }
}

?>