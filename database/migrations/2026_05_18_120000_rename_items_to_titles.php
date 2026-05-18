<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenameItemsToTitles extends Migration
{
    public function up()
    {
        Schema::table('ratings', function ($table) {
            $table->dropForeign(['item_id']);
        });

        Schema::table('genre_item', function ($table) {
            $table->dropForeign(['item_id']);
            $table->dropForeign(['genre_id']);
            $table->dropPrimary(['item_id', 'genre_id']);
        });

        Schema::rename('items', 'titles');
        Schema::rename('genre_item', 'genre_title');

        DB::statement('ALTER TABLE titles CHANGE title name VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE ratings CHANGE item_id title_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE genre_title CHANGE item_id title_id BIGINT UNSIGNED NOT NULL');

        Schema::table('ratings', function ($table) {
            $table->foreign('title_id')->references('id')->on('titles')->cascadeOnDelete();
        });

        Schema::table('genre_title', function ($table) {
            $table->primary(['title_id', 'genre_id']);
            $table->foreign('title_id')->references('id')->on('titles')->cascadeOnDelete();
            $table->foreign('genre_id')->references('id')->on('genres')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('ratings', function ($table) {
            $table->dropForeign(['title_id']);
        });

        Schema::table('genre_title', function ($table) {
            $table->dropForeign(['title_id']);
            $table->dropForeign(['genre_id']);
            $table->dropPrimary(['title_id', 'genre_id']);
        });

        DB::statement('ALTER TABLE ratings CHANGE title_id item_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE genre_title CHANGE title_id item_id BIGINT UNSIGNED NOT NULL');

        Schema::rename('genre_title', 'genre_item');
        Schema::rename('titles', 'items');
        DB::statement('ALTER TABLE items CHANGE name title VARCHAR(255) NOT NULL');

        Schema::table('ratings', function ($table) {
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
        });

        Schema::table('genre_item', function ($table) {
            $table->primary(['item_id', 'genre_id']);
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->foreign('genre_id')->references('id')->on('genres')->cascadeOnDelete();
        });
    }
}
