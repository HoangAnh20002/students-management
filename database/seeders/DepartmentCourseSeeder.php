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
        $departments = Department::all();
        $courses = Course::all();

        foreach ($departments as $department) {
            $selectedCourses = $courses->random(rand(1, 4));

            foreach ($selectedCourses as $course) {
                DepartmentCourse::create([
                    'department_id' => $department->id,
                    'course_id' => $course->id,
                ]);
            }
        }
    }
}
