<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropImdbIdFromTitlesTable extends Migration
{
    public function up()
    {
        Schema::table('titles', function (Blueprint $table) {
            $table->dropColumn('imdb_id');
        });
    }

    public function down()
    {
        Schema::table('titles', function (Blueprint $table) {
            $table->string('imdb_id')->unique()->after('year');
        });
    }
}
