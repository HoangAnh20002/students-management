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

        for ($i = 0; $i < 95; $i++) {
            // Tạo người dùng mới
            $user = User::create([
                "name" => $faker->userName,
                "password" => Hash::make('12345678'),
                "full_name" => $faker->name . "nguyen",
            ]);

            // Chọn một khoa ngẫu nhiên
            $department = Department::inRandomOrder()->first();

            // Tạo sinh viên với thông tin
            Student::create([
                'user_id' => $user->id,
                'department_id' => $department->id,
                'student_code' => $faker->randomNumber(8),
                'email' => $faker->unique()->safeEmail,
                'birth_date' => $faker->date,
                'image' => $faker->imageUrl,
            ]);
        }
    }
}
