<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use App\Models\Title;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            [
                'data' => [
                    'created_by' => 1,
                    'name' => 'Interstellar',
                    'media_id' => 1,
                    'year' => '2014',
                ],
                'genres' => ['Sci-Fi', 'Drama']                            
            ],
            [
                'data' => [
                    'created_by' => 1,
                    'name' => 'Tangled',
                    'media_id' => 1,
                    'year' => '2010',
                ],
                'genres' => ['Animation', 'Family', 'Musical']                            
            ],
            [
                'data' => [
                    'created_by' => 1,
                    'name' => 'The Big Bang Theory',
                    'media_id' => 2,
                    'year' => '2007-2019',
                ],
                'genres' => ['Comedy', 'Romance']                            
            ],
            [
                'data' => [
                    'created_by' => 1,
                    'name' => 'Batman Begins',
                    'media_id' => 1,
                    'year' => '2005',
                ],
                'genres' => ['Action', 'Superheroes']                            
            ],
            [
                'data' => [
                    'created_by' => 1,
                    'name' => 'Orange Is the New Black',
                    'media_id' => 2,
                    'year' => '2013-2019',
                ],
                'genres' => ['Drama', 'Comedy']                            
            ]
        ];

        foreach ($titles as $entry) {
            $title = Title::firstOrCreate(
                ['name' => $entry['data']['name'], 'media_id' => $entry['data']['media_id']],
                $entry['data']
            );

            $genreIds = Genre::whereIn('name', $entry['genres'])
                ->pluck('id')
                ->toArray();

            $title->genres()->sync($genreIds);
        }
    }
}
