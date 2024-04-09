<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $chunkSize = 10000;

        $totalRecords = 300000;

        $iterations = ceil($totalRecords / $chunkSize);

        for ($i = 0; $i < $iterations; $i++) {
            $this->createChunk($chunkSize);
        }
    }

    /**
     * Create a chunk of student records.
     *
     * @param int $chunkSize
     * @return void
     */
    protected function createChunk($chunkSize)
    {
        Student::factory()->times($chunkSize)->create();
    }


}
