<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenameUserIdToCreatedByInRatingsTable extends Migration
{
    public function up()
    {
        Schema::table('ratings', function ($table) {
            $table->dropForeign(['user_id']);
        });

        DB::statement('ALTER TABLE ratings CHANGE user_id created_by BIGINT UNSIGNED NOT NULL AFTER created_at');

        Schema::table('ratings', function ($table) {
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('ratings', function ($table) {
            $table->dropForeign(['created_by']);
        });

        DB::statement('ALTER TABLE ratings CHANGE created_by user_id BIGINT UNSIGNED NOT NULL AFTER id');

        Schema::table('ratings', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
}
