<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Media;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $media = [
            'movie',
            'series',
            'book',
            'song'
        ];

        foreach ($media as $name) {
            Media::firstOrCreate(['name' => $name]);
        }
    }
}
