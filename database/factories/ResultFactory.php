<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Result;
use App\Models\User;
use App\Models\Course;

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
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'course_id' => function () {
                return Course::factory()->create()->id;
            },
            'mark' => $this->faker->randomFloat(1, 0, 10),
        ];
    }
}
