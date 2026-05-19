<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                "email" => "naclaraspam@gmail.com",
                "username" => "naclara",
                "password" => "123",
                "role_id" => 2
            ],
            [
                "email" => "tifanymporto@gmail.com",
                "username" => "titiporto",
                "password" => "123",
                "role_id" => 1
            ]
        ];

        foreach ($users as $user) {
            User::firstOrCreate($user);
        }
    }
}
