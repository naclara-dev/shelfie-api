<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'data' => [
                    'title' => 'Interstellar',
                    'type' => 1,
                    'year' => '2014',
                    'imdb_id' => 'tt0816692',
                ],
                'genres' => ['Sci-Fi', 'Drama']                            
            ],
            [
                'data' => [
                    'title' => 'Tangled',
                    'type' => 1,
                    'year' => '2010',
                    'imdb_id' => 'tt0398286',
                ],
                'genres' => ['Animation', 'Family', 'Musical']                            
            ],
            [
                'data' => [
                    'title' => 'The Big Bang Theory',
                    'type' => 2,
                    'year' => '2007-2019',
                    'imdb_id' => 'tt0898266',
                ],
                'genres' => ['Comedy', 'Romance']                            
            ],
            [
                'data' => [
                    'title' => 'Batman Begins',
                    'type' => 1,
                    'year' => '2005',
                    'imdb_id' => 'tt0372784',
                ],
                'genres' => ['Action', 'Superheroes']                            
            ],
            [
                'data' => [
                    'title' => 'Orange Is the New Black',
                    'type' => 2,
                    'year' => '2013-2019',
                    'imdb_id' => 'tt2372162',
                ],
                'genres' => ['Drama', 'Comedy']                            
            ]
        ];

        foreach ($items as $entry) {
            $item = Item::firstOrCreate(
                ['imdb_id' => $entry['data']['imdb_id']],
                $entry['data']
            );

            $genreIds = Genre::whereIn('name', $entry['genres'])
                ->pluck('id')
                ->toArray();

            $item->genres()->sync($genreIds);
        }
    }
}
