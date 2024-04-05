<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\DepartmentStudent;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DepartmentStudent>
 */
class DepartmentStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DepartmentStudent::class;

    public function definition(): array
    {
    }

}
