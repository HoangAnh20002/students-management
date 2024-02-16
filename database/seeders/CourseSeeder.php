<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Courses = ['Math', 'History ', 'English', 'Chemistry '];
        foreach ($Courses as $value) {
            Course::create([
                'name' => $value,
            ]);
        }
    }
}
