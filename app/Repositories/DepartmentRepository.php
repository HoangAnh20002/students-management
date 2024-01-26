<?php
namespace App\Repositories;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
   public function __construct(Model $model)
   {
       parent::__construct($model);
   }
}
