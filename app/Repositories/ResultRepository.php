<?php
namespace App\Repositories;
use App\Repositories\Interfaces\ResultRepositoryInterface;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class ResultRepository extends BaseRepository implements ResultRepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
