<?php
namespace App\Repositories\Interfaces;

interface StudentRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllStudentsWithUserInfo();
}

