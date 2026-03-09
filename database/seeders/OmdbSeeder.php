<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Item;

class OmdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $url = 'http://www.omdbapi.com/';
        $params = [
            'apikey' => env('OMDB_KEY'),
            's' => 'star',
            'type' => 'movie',
            'page' => '1'
        ];

        $response = Http::get($url, $params);
        $movies = $response->json()['Search'] ?? [];

        foreach ($movies as $movie) {
            Item::create([
                'title' => $movie['Title'],
                'year' => $movie['Year'],
                'type' => $movie['Type']
            ]);
        }
    }
}
