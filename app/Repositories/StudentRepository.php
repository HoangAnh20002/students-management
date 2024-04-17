<?php
namespace App\Repositories;
use App\Enums\Base;
use App\Mail\StudentCreated;
use App\Models\Department;
use App\Models\Result;
use App\Models\User;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Models\Student;
use Couchbase\DesignDocument;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
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
    public function getWithRelationship($page)
    {
        return $this->model->latest('id')->with([
            'user' => function ($query) {
                $query->select('id', 'full_name', 'email');
            },
            'course' => function($query){
            $query->select('name');
            },
            'department',
            'result' => function ($query) {
                $query->select('student_id', 'course_id', 'mark');
            }
        ])->paginate(Base::PAGE);
    }
    public function createWithUser(array $data)
    {
        $department = Department::findOrFail($data['department_id']);
        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => Base::STUDENT,
        ]);
        $student = $this->model->create([
            'user_id' => $user->id,
            'student_code' => '',
            'image' => $data['image'],
            'date_of_birth' => $data['date_of_birth'],
        ]);
        $student->student_code = "AP" . "-" . strtoupper(substr($department->name, 0, 2)) . "-" . $student->id;
        $student->save();
        $student->department()->attach($data['department_id']);
        $student->course()->attach($data['courses']);
        foreach ($data['courses'] as $courseId) {
            Result::create([
                'student_id' => $student->id,
                'course_id' => $courseId,
                'mark' => null,
            ]);
        }
            $password = $data['password'];
            Mail::to($user->email)->send(new StudentCreated($user->full_name, $user->email, $password));
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
        $student->department()->sync($departmentId);
        $student->course()->sync($courseIds);
        foreach ($courseIds as $courseId) {
            $existingResult = Result::where('student_id', $student->id)
                ->where('course_id', $courseId)
                ->first();
            if (!$existingResult) {
                Result::create([
                    'student_id' => $student->id,
                    'course_id' => $courseId,
                    'mark' => null,
                ]);
            }
        }
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
        $hasNullMark = false;

        if ($totalCourses > 0) {
            foreach ($student->result as $result) {
                if ($result->mark === null) {
                    $hasNullMark = true;
                } elseif ($result->mark != 0) {
                    $totalMarks += $result->mark;
                }
            }
            if ($hasNullMark || $student->course->count() < $student->department->last()->course->count()) {
                return 'N/A';
            }
            return $totalCourses > 0 ? $totalMarks / $totalCourses : 0;
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

        $query = $this->model->query()->with(['course', 'result', 'department', 'course']);

        if ($ageFrom !== null && $ageTo === null) {
            $query->whereDate('date_of_birth', '<=', now()->subYears($ageFrom)->format('Y-m-d'));
        } elseif ($ageFrom === null && $ageTo !== null) {
            $query->whereDate('date_of_birth', '>=', now()->subYears($ageTo)->format('Y-m-d'));
        } elseif ($ageFrom !== null && $ageTo !== null) {
            $query->whereDate('date_of_birth', '<=', now()->subYears($ageFrom)->format('Y-m-d'))
                ->whereDate('date_of_birth', '>=', now()->subYears($ageTo)->format('Y-m-d'));
        }

        $query->leftJoin('results', 'results.student_id', '=', 'students.id')
            ->selectRaw('students.id, students.user_id, students.student_code, students.image, students.date_of_birth, AVG(results.mark) as average_score')
            ->groupBy('students.id');

        if ($resultFrom !== null && $resultTo === null) {
            $query->having('average_score', '>=', $resultFrom);
        } elseif ($resultFrom === null && $resultTo !== null) {
            $query->having('average_score', '<=', $resultTo);
        } elseif ($resultFrom !== null && $resultTo !== null) {
            $query->havingBetween('average_score', [$resultFrom, $resultTo]);
        }

        $students = $query->paginate(Base::PAGE);

        return $students;
    }

    public function updateAvatar($studentId, $avatar)
    {
        $student = $this->model->findOrFail($studentId);
        if ($avatar) {
            if ($student->avatar) {
                Storage::delete('avatars/' . $student->avatar);
            }
            $student->image = $avatar;
            $student->save();
        }
    }
    public function getAllWithAverageScoreLessThanFive($chunkSize, $offset)
    {
        return $this->model->query()
            ->with(['course', 'result', 'department', 'course'])
            ->leftJoin('results', 'results.student_id', '=', 'students.id')
            ->selectRaw('
            students.id,
            students.user_id,
            students.student_code,
            students.image,
            students.date_of_birth,
            AVG(results.mark) as average_score
        ')
            ->groupBy('students.id')
            ->havingRaw('average_score < ?', [5])
            ->skip($offset)
            ->take($chunkSize)
            ->get();
    }

}
