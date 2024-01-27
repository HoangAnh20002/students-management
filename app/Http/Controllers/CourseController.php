<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseRepositoryInterface;

    public function __construct(CourseRepositoryInterface $courseRepositoryInterface)
    {
        $this->courseRepositoryInterface = $courseRepositoryInterface;
    }

    public function index()
    {
        // Lấy danh sách các khóa học
        $courses = $this->courseRepositoryInterface->all();

        return view('welcome', compact('courses'));
    }
}
