<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration {
    public function up() {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('item_id');
            $table->integer('grade');
            $table->string('comment');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('ratings');
    }
}

?>