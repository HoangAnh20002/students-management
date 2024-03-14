<?php
namespace App\Repositories\Interfaces;

interface StudentRepositoryInterface extends BaseRepositoryInterface
{
    public function createWithUser(array $data);
    public function updateStudent(array $data, $id, $departmentId, $courseIds);
    public function deleteStudent($id);
    public function search($resultFrom, $resultTo,$ageFrom, $ageTo);
}

