<?php
namespace App\Repositories;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
    public function getModel()
    {
        return $this->model = app()->make(Student::class);
    }
}
