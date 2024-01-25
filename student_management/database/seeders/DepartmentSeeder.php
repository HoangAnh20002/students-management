<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Departments = ['Công nghệ', 'Tài chính ', 'Kinh doanh', 'Làm ruộng'];
        foreach ($Departments as $value) {
            Department::create([
                'name' => $value,
            ]);
        }
    }
}
