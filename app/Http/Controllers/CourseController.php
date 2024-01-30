<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use App\Repositories\DepartmentRepository;

class CourseController extends Controller
{
    protected $courseRepository;
    protected $departmentRepository;

    public function __construct(CourseRepository $courseRepository,
                                DepartmentRepository $departmentRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $courses = $this->courseRepository->all();

        return view('welcome', compact('courses'));
    }
}
