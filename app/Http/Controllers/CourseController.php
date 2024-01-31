<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;

class CourseController extends Controller
{
    protected $courseRepository;


    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index()
    {
        $courses = $this->courseRepository->all();
        return view('welcome', compact('courses'));
    }
}
