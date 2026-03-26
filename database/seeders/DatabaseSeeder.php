<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(ItemSeeder::class);        
    }
}