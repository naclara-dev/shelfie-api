<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenameTypeToMediaIdInTitlesTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE titles DROP FOREIGN KEY items_type_id_foreign');

        DB::statement('ALTER TABLE titles CHANGE type_id media_id BIGINT UNSIGNED NOT NULL');

        Schema::table('titles', function ($table) {
            $table->foreign('media_id')->references('id')->on('media')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('titles', function ($table) {
            $table->dropForeign(['media_id']);
        });

        DB::statement('ALTER TABLE titles CHANGE media_id type_id BIGINT UNSIGNED NOT NULL');

        Schema::table('titles', function ($table) {
            $table->foreign('type_id')->references('id')->on('types')->cascadeOnDelete();
        });
    }
}
