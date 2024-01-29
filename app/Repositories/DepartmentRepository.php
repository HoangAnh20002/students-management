<?php
namespace App\Repositories;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
   public function __construct(Model $model)
   {
       parent::__construct($model);
   }
   public function getModel()
   {
       return $this->model =app()->make(Department::class);
   }
}
