<?php


namespace App\Repositories;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    public function authenticate($credentials): bool
    {
        return Auth::attempt($credentials);
    }
}

