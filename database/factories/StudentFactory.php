<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'department_id' => function () {
                return Department::factory()->create()->id;
            },
            'student_code' => $this->faker->randomNumber(8),
            'email' => $this->faker->unique()->safeEmail,
            'date_of_birth' => $this->faker->date,
            'image' => $this->faker->imageUrl,
        ];
    }
}
