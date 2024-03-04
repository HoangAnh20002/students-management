<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\Student;
use App\Models\User;
use App\Models\Department;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            $user = User::create([
                "password" => Hash::make('12345678'),
                "full_name" => $faker->name . "nguyen",
                'email' => $faker->unique()->safeEmail,
                'role' => '0',
            ]);

            $department = Department::inRandomOrder()->first();

            Student::create([
                'user_id' => $user->id,
                'department_id' => $department->id,
                'student_code' => $faker->randomNumber(8),
                'date_of_birth' => $faker->date,
                'image' => null,
            ]);
        }
    }
}
