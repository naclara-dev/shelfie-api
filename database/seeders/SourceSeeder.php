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
            'imdb',
            'tmdb',
            'tvdb',
            'isbn',
            'google_books',
            'open_library',
            'spotify',
            'apple_music',
        ];

        foreach ($sources as $source) {
            DB::table('sources')->updateOrInsert(
                ['name' => $source],
                ['name' => $source]
            );
        }
    }
}
