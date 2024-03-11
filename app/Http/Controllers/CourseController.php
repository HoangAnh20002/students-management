<?php

namespace App\Http\Controllers;

use App\Enums\Base;
use App\Http\Requests\CourseRequest;
use App\Repositories\CourseRepository;
use App\Repositories\DepartmentRepository;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    protected $courseRepository;


    public function __construct(CourseRepository $courseRepository, DepartmentRepository $departmentRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $role = Auth::user()->role;
        $courses = $this->courseRepository->paginate(Base::PAGE);
        return view('course.index', compact('courses', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Auth::user()->role;
        $departments = $this->departmentRepository->all();
        if ($role == Base::STUDENT) {
            return redirect('login')->with('error', 'Permission denied. Please log in with a valid account.');
        }
        return view('course.create', compact('role', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $data = $request->only('name');
        $departmentIds = $request->input('departments');
        $this->courseRepository->createWithDepartments($data, $departmentIds);
        return redirect('course')->with('success', 'Course added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Auth::user()->role;
        $departments = $this->departmentRepository->all();
        if ($role == Base::STUDENT) {
            return redirect('login')->with('error', 'Permission denied. Please log in with a valid account.');
        }

        $course = $this->courseRepository->find($id);
        if (!$course) {
            return redirect('course')->with('error', 'Course not found');
        }
        return view('course.edit', compact('course', 'role', 'departments'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request)
    {
        $data = $request->only('name');
        $id = $request->input('id');
        $departmentIds = $request->input('departments');

        $course = $this->courseRepository->find($id);
        if (!$course) {
            return redirect('course')->with('error', 'The record not found');
        }
        $this->courseRepository->updateWithDepartments($id, $data, $departmentIds);

        return redirect('course')->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($this->courseRepository->hasStudents($id)) {
            return redirect()->route('course.index')->with('error', 'This course has student records and cannot be deleted.');
        }
        $record = $this->courseRepository->find($id);
        if ($record) {
            $record->delete();
            return redirect()->route('course.index')->with('success', 'Record deleted successfully');
        } else {
            return redirect()->route('course.index')->with('error', 'Record not found');
        }
    }

}
