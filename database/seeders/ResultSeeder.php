<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Result;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunkSize = 10000;

        $totalRecords = 150000;

        $iterations = ceil($totalRecords / $chunkSize);

        for ($i = 0; $i < $iterations; $i++) {
            $this->createChunk($chunkSize);
        }
    }
    /**
     * Create a chunk of result records.
     *
     * @param int $chunkSize
     * @return void
     */
    protected function createChunk($chunkSize)
    {
        Result::factory()->times($chunkSize)->create();
    }


}
