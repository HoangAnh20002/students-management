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
        $Courses = ['Toán', 'Văn ', 'Tiếng Anh', 'Thể dục'];
        foreach ($Courses as $value) {
            Course::create([
                'name' => $value,
            ]);
        }
    }
}
