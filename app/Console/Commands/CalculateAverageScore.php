<?php

namespace App\Console\Commands;

use App\Enums\Base;
use App\Jobs\SendDropOutNotification;
use App\Models\Student;
use Illuminate\Console\Command;
use App\Repositories\StudentRepository;

class CalculateAverageScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-average-score';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    protected $description = 'Calculate average score for students';

    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        parent::__construct();
        $this->studentRepository = $studentRepository;
    }
    public function handle()
    {
        $chunkSize = 1000;
        Student::query()
            ->with(['course', 'result', 'department', 'course'])
            ->leftJoin('results', 'results.student_id', '=', 'students.id')
            ->selectRaw('
            students.id,
            students.user_id,
            students.student_code,
            students.image,
            students.date_of_birth,
            AVG(results.mark) as average_score
        ')
            ->groupBy('students.id')
            ->havingRaw('average_score < ?', [5])
            ->chunk($chunkSize, function ($students) {
                foreach ($students as $student) {
                    SendDropOutNotification::dispatch($student);
                }
            });
    }

}
