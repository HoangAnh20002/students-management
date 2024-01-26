<?php
namespace App\Repositories;
use App\Models\Student;
use App\Repositories\Interfaces\CourseRepositoryInterface;

class CourseRepository implements CourseRepositoryInterface
{
    public function getAllCourse()
    {
        return Student::all();
    }
    public function getCourseById($id)
    {
        return Student::find($id);
    }
}
