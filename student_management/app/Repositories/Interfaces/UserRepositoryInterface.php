<?php
namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAll();
    public function getUserById($id);

}
