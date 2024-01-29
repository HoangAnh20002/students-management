<?php
namespace App\Repositories;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
  public function __construct(Model $model)
  {
      parent::__construct($model);
  }
  public function getModel()
  {
      return $this->model = app()->make(User::class);
  }
}
