<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Item;
use App\Models\Genre;

class OmdbSeeder extends Seeder
{
    /**
     * Populates the "items" table with records from the OMDb API
     *
     * @return void
     */
    public function run()
    {
        # URL params
        $url = 'http://www.omdbapi.com/';
        $apiKey = env('OMDB_KEY');

        # Generic keywords to return many results 
        $keywords = [
            'life',
            'world',
            'story',
            'family',
            'city',
            'house',
            'night',
            'school',
            'doctor',
            'love',
            'war',
            'king',
            'queen',
            'power',
            'law',
            'crime',
            'police',
            'detective',
            'theory',
            'secret',
            'dark',
            'lost',
            'island',
            'game',
            'future'
        ];

        # Makes a request for each keyword
        foreach ($keywords as $keyword) {
            # Goes through pages 1 to 5
            for ($page = 1; $page <= 5; $page++) {

                $response = Http::get($url, [
                    'apikey' => $apiKey,
                    's' => $keyword,
                    'page' => $page
                ]);

                $movies = $response->json()['Search'] ?? [];

                # Creates a new item for each result
                foreach ($movies as $movie) {
                    $item = Item::firstOrCreate([
                        'imdb_id' => $movie['imdbID']
                    ], [
                        'title' => $movie['Title'],
                        'year'  => $movie['Year'],
                        'type'  => $movie['Type']
                    ]);

                    # Searches the item details
                    $details = Http::get($url, [
                        'apikey' => $apiKey,
                        'i' => $movie['imdbID']
                    ])->json();

                    # Retrieves all the item's genres
                    if (!empty($details['Genre'])) {

                        $genreNames = explode(', ', $details['Genre']);
                        $genreIds = [];

                        foreach ($genreNames as $name) {

                            $genre = Genre::firstOrCreate([
                                'name' => $name
                            ]);

                            $genreIds[] = $genre->id;
                        }

                        # Populates the pivot table (genre_item) with all the item's genres
                        $item->genres()->syncWithoutDetaching($genreIds);
                    }
                }
            }
        }
    }
}
