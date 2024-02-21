<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Models\Course;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getModel(){
      return $this->model = app()->make(Course::class);
    }
    public function hasStudents($id){
        $course = Course::findOrFail($id);
        return $course->student()->exists();
    }
}
