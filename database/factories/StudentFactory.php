<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create(['role' => 0])->id;
            },
            'student_code' => $this->faker->randomNumber(8),
            'date_of_birth' => $this->faker->date,
            'image' => null
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Student $student) {
        $departmentIds = range(1, 5);
        $student->department()->attach([
            'department_id' => $this->faker->randomElement($departmentIds),
        ]);
            $courseIds = range(1, 5);
            $chosenCourseIds = $this->faker->randomElements($courseIds, rand(1, 5));
            $student->course()->attach($chosenCourseIds);
        });
    }
}
