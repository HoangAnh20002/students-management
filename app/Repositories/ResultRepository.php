<?php
namespace App\Repositories;
use App\Models\Department;
use App\Repositories\Interfaces\ResultRepositoryInterface;

class ResultRepository extends BaseRepository implements ResultRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getModel()
    {
        return $this->model = app()->make(Department::class);
    }
}
