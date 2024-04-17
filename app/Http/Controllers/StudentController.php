<?php

namespace App\Http\Controllers;

use App\Enums\Base;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StudentRequest;
use App\Mail\CourseRegistrationNotice;
use App\Repositories\CourseRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class StudentController extends Controller
{
    protected $studentRepository;
    protected $userRepository;
    protected $courseRepository;
    protected $departmentRepository;

    public function __construct(StudentRepository $studentRepository, UserRepository $userRepository,
                                CourseRepository  $courseRepository, DepartmentRepository $departmentRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function index(SearchRequest $request)
    {
        $error = '';
        $departments = $this->departmentRepository->all();
        $courses = $this->courseRepository->all();
        $course_sum = $this->courseRepository->getTotalCourses();

        if ($request->isNotFilled('result_from', 'result_to', 'age_from', 'age_to')) {
            $students = $this->studentRepository->getWithRelationship(Base::PAGE);
            foreach ($students as $student) {
                $student->average_score = $this->studentRepository->calculateAverageScore($student);
            }
        } else {
            $students = $this->studentRepository->search($request);
            if ($students->isEmpty()) {
                $error = 'Student not found';
            }
            $students->each(function ($student) {
                $student->average_score = $student->average_score ?? 'N/A';
            });
        }

        return view('student.index', compact('students', 'course_sum', 'error', 'departments', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = $this->departmentRepository->all();
        $courses = $this->courseRepository->all();

        return view('student.create', compact('departments', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        if($request->ajax()) {
            $file_name = null;
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $file_name = $file->getClientOriginalName();
                $file->storeAs('avatars', $file_name, 'public');
            }
            $request->merge(['image' => $file_name]);
            $student = $this->studentRepository->createWithUser($request->only('name', 'full_name', 'email', 'password', 'student_code', 'date_of_birth', 'image', 'department_id', 'courses'));

            if ($student) {
                return response()->json(['status' => 'success', 'message' => 'Student created successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to create student'], 422);
            }

        } else{
            $file_name = null;
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $file_name = $file->getClientOriginalName();
                $file->storeAs('avatars', $file_name, 'public');
            }

            $request->merge(['image' => $file_name]);
            $student = $this->studentRepository->createWithUser($request->only('name', 'full_name', 'email', 'password', 'student_code', 'date_of_birth', 'image', 'department_id', 'courses'));

            if ($student) {
                return redirect()->route('student.index')->with('success', 'Student created successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to create student');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user();
        $studentIDs = $user->student->pluck('id')->first();
        $student = $this->studentRepository->find($studentIDs);
        $student->average_score = $this->studentRepository->calculateAverageScore($student);

        return view('studentMain', compact('user', 'student'));
    }

    public function updateAvatar(Request $request, $id)
    {
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'avatar.image' => 'The uploaded file must be an image.',
            'avatar.mimes' => 'The uploaded file must be a jpeg, png, jpg, or gif image.',
            'avatar.max' => 'The uploaded file may not be greater than 2MB in size.',
        ]);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $file_name = $file->getClientOriginalName();
            $file->storeAs('avatars', $file_name, 'public');
            $request->merge(['image' => $file_name]);
            $avatar = $request->image;
            $this->studentRepository->updateAvatar($id, $avatar);

            return redirect()->route('studentMain')->with('success', 'Avatar updated successfully');
        } else {
            return redirect()->route('studentMain')->with('error', 'No file uploaded for avatar update.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = $this->studentRepository->find($id);

        if (!$student) {
            return redirect('student.index')->with('error', 'Student not found');
        }

        $departments = $this->departmentRepository->all();
        $courses = $this->courseRepository->all();

        return view('student.edit', compact('courses', 'student', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request)
    {
        $id = $request->input('id');
        $student = $this->studentRepository->find($id);

        if (!$student) {
            return redirect('student')->with('error', 'The record not found');
        }

        if ($request->file('avatar')) {
            $file = $request->avatar;
            $file_name = $file->getClientOriginalName();
            $file->storeAs('avatars', $file_name, 'public');

        } else {
            $old_image = $student->image;
            $file_name = $old_image;
        }

        $request->merge(['image' => $file_name]);
        $data = $request->only(['name', 'full_name', 'email', 'student_code', 'password', 'image', 'date_of_birth']);
        $departmentId = $request->input('department_id');
        $courseIds = $request->input('courses');
        $this->studentRepository->updateStudent($data, $id, $departmentId, $courseIds);

        return redirect('student')->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = $this->studentRepository->find($id);

        if (!$student) {
            return redirect()->route('student.index')->with('error', 'Record not found');
        }

        $this->studentRepository->deleteStudent($id);

        return redirect()->route('student.index')->with('success', 'Record deleted successfully');
    }

    public function sendEmailNotice(Request $request)
    {
        $studentId = $request->input('student_id');
        $student = $this->studentRepository->find($studentId);
        $studentCourse = $student->course;
        $courseDepartment = $student->department->last()->course;
        $notRegisteredCourses = $courseDepartment->diff($studentCourse)->pluck('name');

        Mail::to($student->user->email)->send(new CourseRegistrationNotice($student->user->full_name, $notRegisteredCourses));

        return redirect()->back()->with('success', 'Email notice sent successfully.');
    }
}
