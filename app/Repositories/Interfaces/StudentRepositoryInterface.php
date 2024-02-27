<?php
namespace App\Repositories\Interfaces;

interface StudentRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllStudentsWithUserInfo();
    public function getInfoStudentAndUser();
    public function createWithUser(array $data);
}

