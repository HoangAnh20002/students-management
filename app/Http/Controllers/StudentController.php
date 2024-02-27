<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Repositories\CourseRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;


class StudentController extends Controller
{
    protected $studentRepository;
    protected $userRepository;
    protected $courseRepository;
    protected $departmentRepository;

    public function __construct(StudentRepository $studentRepository,UserRepository $userRepository,CourseRepository $courseRepository,DepartmentRepository $departmentRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
        $this->departmentRepository = $departmentRepository;
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
        $departments = $this->departmentRepository->all();
        $courses = $this->courseRepository->all();
        return view('student.create', compact('departments','courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $file_name = null;
        if($request->hasFile('avatar')){
            $file = $request->avatar;
            $file_name =$file->getClientOriginalName();
            $file->move(public_path('avatars'),$file_name);
        }
        $request->merge(['image'=>$file_name]);
        $student = $this->studentRepository->createWithUser($request->only('name','full_name','email','password','student_code','birth_date','image','department_id','courses'));

        if ($student) {
            return redirect()->route('student.index')->with('success', 'Student created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create student');
        }
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
        $departments = $this->departmentRepository->all();
        $courses = $this->courseRepository->all();

        $student = $this->studentRepository->getInfoStudentAndUser()->find($id);
        if (!$student) {
            return redirect('$students')->with('error', 'Students not found');
        }

        return view('student.edit', compact('courses', 'student', 'departments'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, $id)
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
        $record = $this->studentRepository->find($id);
        if ($record) {
            $record->delete();
            return redirect()->route('course.index')->with('success', 'Record deleted successfully');
        } else {
            return redirect()->route('course.index')->with('error', 'Record not found');
        }
    }

}
