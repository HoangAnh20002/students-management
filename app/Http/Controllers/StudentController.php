<?php

namespace App\Http\Controllers;

use App\Enums\Base;
use App\Repositories\CourseRepository;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    protected $studentRepository;
    protected $userRepository;
    protected $courseRepository;

    public function __construct(StudentRepository $studentRepository,UserRepository $userRepository,CourseRepository $courseRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
    }
    public function index()
    {
        $course_sum = $this->courseRepository->getTotalCoures();
        $students = $this->studentRepository->getAllStudentsWithUserInfo();
        return view('student.index', compact('students','course_sum'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = $this->studentRepository->all();

        return view('student.create', compact('students'));
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
    public function update(CourseRequest $request, $id)
    {
        $data = $request->only('name');
        $departmentIds = $request->input('departments');

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
