<?php

namespace App\Http\Controllers;

use App\Enums\Base;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    protected $studentRepository;
    protected $userRepository;

    public function __construct(StudentRepository $studentRepository,UserRepository $userRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $students = $this->studentRepository->paginate(Base::PAGE);
        $students_data = $this->userRepository->findByRole(0)->paginate(Base::PAGE);
        return view('student.index', compact('students','students_data'));
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
