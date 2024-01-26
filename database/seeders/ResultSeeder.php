<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Result;
use App\Models\Student;
use App\Models\Course;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lặp để tạo dữ liệu giả mạo cho bảng results
        for ($i = 0; $i < 100; $i++) {
            // Chọn một người dùng và khóa học ngẫu nhiên
            $student = Student::inRandomOrder()->first();
            $course = Course::inRandomOrder()->first();

            // Tạo kết quả với thông tin giả mạo
            Result::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'mark' => $faker->randomFloat(2, 0, 10),
            ]);
        }
    }
}
