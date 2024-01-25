<?php
namespace App\Repositories;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Models\Student;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function getAllDepartment()
    {
        return Student::all();
    }
    public function getDepartmentById($id)
    {
        return Student::find($id);
    }
}
