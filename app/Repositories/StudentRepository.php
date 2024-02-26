<?php
namespace App\Repositories;
use App\Enums\Base;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getModel()
    {
        return $this->model = app()->make(Student::class);
    }
    public function getAllStudentsWithUserInfo(){
        return $this->model->with('user')->withCount('course')->paginate(Base::PAGE);
    }
}
