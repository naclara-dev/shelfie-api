<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenameRoleToRoleIdInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->dropForeign(['role']);
        });

        DB::statement('ALTER TABLE users CHANGE role role_id BIGINT UNSIGNED NOT NULL');

        Schema::table('users', function ($table) {
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropForeign(['role_id']);
        });

        DB::statement('ALTER TABLE users CHANGE role_id role BIGINT UNSIGNED NOT NULL');

        Schema::table('users', function ($table) {
            $table->foreign('role')->references('id')->on('roles')->cascadeOnDelete();
        });
    }
}
