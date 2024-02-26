<?php
namespace App\Repositories;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{
  public function __construct()
  {
      parent::__construct();
  }
  public function getModel()
  {
      return $this->model = app()->make(User::class);
  }
    public function findByRole($role)
    {
        return $this->model->where('role', $role);
    }
}
