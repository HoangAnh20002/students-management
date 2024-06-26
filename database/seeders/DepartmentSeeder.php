<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $Departments = ['Technology ', 'Financial ', 'Business', 'Information','Construction'];
        foreach ($Departments as $value) {
            Department::create([
                'name' => $value,
            ]);
        }
    }
}
