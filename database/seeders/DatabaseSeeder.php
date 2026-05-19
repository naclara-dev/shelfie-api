<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MediaSeeder::class);
        $this->call(SourceSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(TitleSeeder::class);
        $this->call(TitleIdentifierSeeder::class);
    }
}
