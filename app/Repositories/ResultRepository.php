<?php
namespace App\Repositories;
use App\Repositories\Interfaces\ResultRepositoryInterface;
use App\Models\Student;

class ResultRepository implements ResultRepositoryInterface
{
    public function getAllResult()
    {
        return Student::all();
    }
    public function getResultById($id)
    {
        return Student::find($id);
    }
}
