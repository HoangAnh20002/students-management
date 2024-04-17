<?php

namespace App\Jobs;

use App\Models\Result;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Writer;

class ExportResults implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['ID', 'Student ID', 'Course ID', 'Mark']);

        Result::chunk(1000, function ($results) use ($csv) {
            foreach ($results as $result) {
                $csv->insertOne([$result->id, $result->student_id, $result->course_id, $result->mark]);
            }
        });

        $csv->output('results.csv');
    }
}
