<?php

namespace App\Console\Commands;

use App\Jobs\SendDropOutNotification;
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
        $students = $this->studentRepository->all();
        foreach ($students as $student) {
            $student->average_score = $this->studentRepository->calculateAverageScore($student);
            $this->info('Average score for student ' . $student->id . ': ' . $student->average_score);
            if ($student->average_score < 5) {
                SendDropOutNotification::dispatch($student);
                $this->info('Drop out notification sent to ' . $student->user->email);
            }
        }
    }
}
