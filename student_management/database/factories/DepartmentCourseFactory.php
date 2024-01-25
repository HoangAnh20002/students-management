<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Department;
use App\Models\DepartmentCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DepartmentCourse>
 */
class DepartmentCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DepartmentCourse::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => function () {
                return Department::factory()->create()->id;
            },
            'course_id' => function () {
                return Course::factory()->create()->id;
            },
        ];
    }
}
