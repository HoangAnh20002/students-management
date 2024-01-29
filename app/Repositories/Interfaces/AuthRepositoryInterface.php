<?php

namespace App\Repositories\Interfaces;

interface AuthRepositoryInterface
{
    public function authenticate($credentials);
}
