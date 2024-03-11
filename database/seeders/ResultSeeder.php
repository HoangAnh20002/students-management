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

        $students = Student::all();
        $courses = Course::all();

        foreach ($students as $student) {
            $selectedCourses = $courses->random(rand(1, 4));

            foreach ($selectedCourses as $course) {
                Result::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'mark' => $faker->randomFloat(2, 0, 10),
                ]);
            }
        }
    }


}
