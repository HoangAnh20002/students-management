<?php
namespace App\Repositories;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getModel()
    {
        return $this->model = app()->make(Student::class);
    }
}
