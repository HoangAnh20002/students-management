<?php
namespace App\Repositories;
use App\Models\Department;
use App\Repositories\Interfaces\ResultRepositoryInterface;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class ResultRepository extends BaseRepository implements ResultRepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
    public function getModel()
    {
        return $this->model = app()->make(Department::class);
    }
}
