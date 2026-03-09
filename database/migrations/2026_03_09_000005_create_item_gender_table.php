<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemGenderTable extends Migration {
    public function up() {
        Schema::create('item_gender', function (Blueprint $table) {            
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('gender_id')->constrained('genders')->cascadeOnDelete();
            $table->primary('item_id', 'gender_id');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('item_gender');
    }
}

?>