<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameTypesTableToMedia extends Migration
{
    public function up()
    {
        Schema::rename('types', 'media');
    }

    public function down()
    {
        Schema::rename('media', 'types');
    }
}
