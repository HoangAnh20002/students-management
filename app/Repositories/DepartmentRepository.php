<?php
namespace App\Repositories;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
   public function __construct()
   {
       parent::__construct();
   }
   public function getModel()
   {
       return $this->model =app()->make(Department::class);
   }
}
