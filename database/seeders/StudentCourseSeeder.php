<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentCourse;
use App\Models\Student;
use App\Models\Course;

class StudentCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $courses = Course::all();

        foreach ($students as $student) {
            $selectedCourses = $courses->random(rand(1, 4));

            foreach ($selectedCourses as $course) {
                StudentCourse::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                ]);
            }
        }
    }
}
