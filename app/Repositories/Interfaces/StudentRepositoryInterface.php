<?php
namespace App\Repositories\Interfaces;

interface StudentRepositoryInterface
{
    public function getAllStudent();
    public function getStudentById($id);
}

