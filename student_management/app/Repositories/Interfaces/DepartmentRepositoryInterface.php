<?php
namespace App\Repositories\Interfaces;

interface DepartmentRepositoryInterface
{
    public function getAllDepartment();
    public function getDepartmentById($id);

}
