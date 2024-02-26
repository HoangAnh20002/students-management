<?php
namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByRole($role);
}
