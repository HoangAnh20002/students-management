<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Result;

class ResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Result::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $studentIds = Student::pluck('id')->toArray();
        $courseIds = range(1, 5);

        return [
            'student_id' => $this->faker->randomElement($studentIds),
            'course_id' => $this->faker->randomElement($courseIds),
            'mark' => $this->faker->randomFloat(1, 0, 10),
        ];
    }

}
