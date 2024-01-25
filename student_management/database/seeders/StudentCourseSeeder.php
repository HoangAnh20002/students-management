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
        // Lấy danh sách tất cả sinh viên và khóa học
        $students = Student::all();
        $courses = Course::all();

        // Lặp qua từng sinh viên để gán ngẫu nhiên một số khóa học
        foreach ($students as $student) {
            // Lấy một số lượng ngẫu nhiên của các khóa học
            $selectedCourses = $courses->random(rand(1, 4));

            // Gán sinh viên vào từng khóa học đã chọn
            foreach ($selectedCourses as $course) {
                StudentCourse::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                ]);
            }
        }
    }
}
