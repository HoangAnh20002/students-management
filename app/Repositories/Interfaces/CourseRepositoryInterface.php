<?php
namespace App\Repositories\Interfaces;

use App\Models\Student;

interface CourseRepositoryInterface extends BaseRepositoryInterface
{
    public function hasStudents($id);
    public function createWithDepartments(array $data, array $departmentIds);
    public function updateWithDepartments($id, array $data, array $departmentIds);
    public function getTotalCoures();
    public function confirmCourseRegistration(Student $student, array $courseIds);
}


