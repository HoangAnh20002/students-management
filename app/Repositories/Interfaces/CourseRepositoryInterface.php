<?php
namespace App\Repositories\Interfaces;

interface CourseRepositoryInterface extends BaseRepositoryInterface
{
    public function hasStudents($id);
}


