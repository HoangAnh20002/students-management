<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            User::create([
                "name" => $faker->name(),
                "password" => Hash::make('12345678'),
                "full_name" => $faker->name . "nguyen",
            ]);
        }
    }
}
