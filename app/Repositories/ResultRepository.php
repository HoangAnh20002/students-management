<?php
namespace App\Repositories;
use App\Models\Result;
use App\Repositories\Interfaces\ResultRepositoryInterface;

class ResultRepository extends BaseRepository implements ResultRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getModel()
    {
        return $this->model = app()->make(Result::class);
    }
    public function updateMarks(array $resultIds, array $marks)
    {
        if (count($resultIds) !== count($marks)) {
            return false;
        }

        $count = count($resultIds);
        for ($i = 0; $i < $count; $i++) {
            $resultId = $resultIds[$i];
            $mark = $marks[$i];
            $result = $this->model->find($resultId);
            if ($result) {
                $result->mark = $mark;
                $result->save();
            } else {
                return false;
            }
        }
        return true;
    }
}
