<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sources = [
            ['name' => 'imdb', 'media_id' => 1],
            ['name' => 'tmdb', 'media_id' => 1],
            ['name' => 'tvdb', 'media_id' => 2],
            ['name' => 'isbn', 'media_id' => 3],
            ['name' => 'google_books', 'media_id' => 3],
            ['name' => 'open_library', 'media_id' => 3],
            ['name' => 'spotify', 'media_id' => 4],
            ['name' => 'apple_music', 'media_id' => 4],
        ];

        foreach ($sources as $source) {
            DB::table('sources')->updateOrInsert(
                ['name' => $source['name']],
                $source
            );
        }
    }
}
