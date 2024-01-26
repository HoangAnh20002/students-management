<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Models\Course;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }
}
