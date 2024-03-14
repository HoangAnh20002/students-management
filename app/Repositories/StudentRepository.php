<?php
namespace App\Repositories;
use App\Enums\Base;
use App\Mail\StudentCreated;
use App\Models\Department;
use App\Models\User;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Models\Student;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getModel()
    {
        return $this->model = app()->make(Student::class);
    }
    public function createWithUser(array $data)
    {
        $department = Department::findOrFail($data['department_id']);
        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => '0',
        ]);
            $student = $this->model->create([
                'user_id' => $user->id,
                'student_code' =>'',
                'image' => $data['image'],
                'date_of_birth' => $data['date_of_birth'],
                'department_id' => $data['department_id'],
            ]);
        $student->student_code = "AP" . "-" . strtoupper(substr($department->name, 0, 2)) . "-" . $student->id;
        $student->save();
        $student->course()->attach($data['courses']);
        $password = $data['password'];
        Mail::to($user->email)->send(new StudentCreated($user->full_name,$user->email, $password));

        return $student;
    }
    public function updateStudent(array $data, $id, $departmentId, $courseIds)
    {
        $student = $this->model->findOrFail($id);
        $user = $student->user;
        $user->update([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => Base::STUDENT,
        ]);
        $student->update([
            'image' => $data['image'],
            'date_of_birth' => $data['date_of_birth'],
            'department_id' => $departmentId,
        ]);

        $student->course()->sync($courseIds);
        return $student;
    }
    public function deleteStudent($id){
        $student = $this->model->findOrFail($id);
        $student->user()->delete();
        $student->delete();
    }
    public function calculateAverageScore(Student $student)
    {
        $totalMarks = 0;
        $totalCourses = $student->course->count();
        if ($totalCourses > 0) {
            foreach ($student->course as $course) {
                $result = $course->result;
                if ($result) {
                    $totalMarks += $result->mark;
                }
            }
            return $totalMarks / $totalCourses;
        } else {
            return null;
        }
    }

    public function search($request)
    {
        $resultFrom = $request->query('result_from');
        $resultTo = $request->query('result_to');
        $ageFrom = $request->query('age_from');
        $ageTo = $request->query('age_to');
        $students = $this->model->with('course.result')->get();
        $filteredStudents = $students->filter(function ($student) use ($resultFrom, $resultTo, $ageFrom, $ageTo) {
            $totalMarks = 0;
            $totalCourses = $student->course->count();
            foreach ($student->course as $course) {
                $result = $course->result;
                if ($result) {
                    $totalMarks += $result->mark;
                }
            }
            $averageScore = $totalCourses > 0 ? $totalMarks / $totalCourses : 0;
            if($ageFrom !== null && $ageTo === null){
                return $student->date_of_birth >= now()->subYears($ageFrom);
            }
            if($resultFrom !== null && $resultTo === null){
                return $averageScore >= $resultFrom;
            }
            $errors = [];
            if ($resultFrom > $resultTo) {
                $errors[] = 'The result to must be greater than or equal to the result from.';
            }
            if ($ageFrom > $ageTo) {
                $errors[] = 'The age to must be greater than or equal to the age from.';
            }
            if (!empty($errors)) {
                return redirect()->route('student.index')->with('error', $errors);
            }
            if($resultTo == null && $resultFrom == null){
                return  $student->date_of_birth >= now()->subYears($ageTo) &&
                    $student->date_of_birth <= now()->subYears($ageFrom);
            }
            elseif($ageFrom == null && $ageTo == null){
                return $averageScore >= $resultFrom && $averageScore <= $resultTo;
            }
            return $averageScore >= $resultFrom && $averageScore <= $resultTo &&
                $student->date_of_birth >= now()->subYears($ageTo) &&
                $student->date_of_birth <= now()->subYears($ageFrom);
        });


            $perPage = Base::PAGE;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $pagedData = $filteredStudents->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $students = new LengthAwarePaginator($pagedData, count($filteredStudents), $perPage, $currentPage);
            return $students;
    }
    public function updateAvatar($studentId, $avatar)
    {
        $student = Student::findOrFail($studentId);
        if ($avatar) {
            if ($student->avatar) {
                Storage::delete('avatars/' . $student->avatar);
            }
            $student->image = $avatar;
            $student->save();
        }
    }
}
