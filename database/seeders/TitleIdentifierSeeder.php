<?php

namespace Database\Seeders;

use App\Models\Source;
use App\Models\Title;
use App\Models\TitleIdentifier;
use Illuminate\Database\Seeder;

class TitleIdentifierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imdb = Source::where('name', 'imdb')->first();

        if (!$imdb) {
            return;
        }

        $identifiers = [
            [
                'title_id' => 1,
                'value' => 'tt0816692',
            ],
            [
                'title_id' => 2,
                'value' => 'tt0398286',
            ],
            [
                'title_id' => 3,
                'value' => 'tt0898266',
            ],
            [
                'title_id' => 4,
                'value' => 'tt0372784',
            ],
            [
                'title_id' => 5,
                'value' => 'tt2372162',
            ],
        ];

        foreach ($identifiers as $identifier) {
            $title = Title::find($identifier['title_id']);

            if (!$title) {
                continue;
            }

            TitleIdentifier::updateOrCreate(
                [
                    'source_id' => $imdb->id,
                    'value' => $identifier['value'],
                ],
                [
                    'title_id' => $title->id,
                ]
            );
        }
    }
}
