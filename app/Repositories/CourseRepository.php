<?php

namespace App\Repositories;

use App\Models\Result;
use App\Models\Student;
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
        $course = $this->model->findOrFail($id);
        return $course->student()->exists();
    }
    public function createWithDepartments(array $data, array $departmentIds)
    {
        $course = $this->model->create($data);
        $course->department()->attach($departmentIds);
        return $course;
    }
    public function updateWithDepartments($id, array $departmentIds)
    {
        $course = $this->model->findOrFail($id);
        $course->department()->sync($departmentIds);
        return $course;
    }
    public function getTotalCourses(){
        return $this->model->count();
    }
    public function confirmCourseRegistration(Student $student, array $courseIds)
    {
        $student->course()->attach($courseIds);
        foreach ($courseIds as $courseId) {
            Result::create([
                'student_id' => $student->id,
                'course_id' => $courseId,
                'mark' => null,
            ]);
        }
    }
}
