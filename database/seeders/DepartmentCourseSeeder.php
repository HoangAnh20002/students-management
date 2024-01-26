<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DepartmentCourse;
use App\Models\Department;
use App\Models\Course;

class DepartmentCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách tất cả khoa và khóa học
        $departments = Department::all();
        $courses = Course::all();

        // Lặp qua từng khoa để gán ngẫu nhiên một số khóa học
        foreach ($departments as $department) {
            // Lấy một số lượng ngẫu nhiên của các khóa học
            $selectedCourses = $courses->random(rand(1, 4));

            // Gán khoa vào từng khóa học đã chọn
            foreach ($selectedCourses as $course) {
                DepartmentCourse::create([
                    'department_id' => $department->id,
                    'course_id' => $course->id,
                ]);
            }
        }
    }
}
