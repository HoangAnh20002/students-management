<?php
namespace App\Repositories;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface
{
    public function getAllStudent()
    {
        return Student::all();
    }
    public function getStudentById($id)
    {
        return Student::find($id);
    }
}
