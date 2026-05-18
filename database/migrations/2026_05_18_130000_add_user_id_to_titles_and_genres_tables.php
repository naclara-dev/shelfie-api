<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTitlesAndGenresTables extends Migration
{
    public function up()
    {
        Schema::table('titles', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('created_at')->constrained('users')->cascadeOnDelete();
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('created_at')->constrained('users')->cascadeOnDelete();
        });

        DB::table('titles')->update(['created_by' => 1]);
        DB::table('genres')->update(['created_by' => 1]);

        DB::statement('ALTER TABLE titles MODIFY created_by BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE genres MODIFY created_by BIGINT UNSIGNED NOT NULL');
    }

    public function down()
    {
        Schema::table('titles', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
}
