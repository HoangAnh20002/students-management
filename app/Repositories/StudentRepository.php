<?php
namespace App\Repositories;
use App\Enums\Base;
use App\Models\User;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Models\Student;

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
    public function getAllStudentsWithUserInfo(){
        return $this->model->with('user')->withCount('course')->paginate(Base::PAGE);
    }
    public function getInfoStudentAndUser()
    {
        return Student::with('user')->get();
    }
    public function createWithUser(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => '0',
        ]);

            $student = $this->model->create([
                'user_id' => $user->id,
                'student_code' => $data['student_code'],
                'image' => $data['image'],
                'birth_date' => $data['birth_date'],
                'department_id' => $data['department_id'],
            ]);

        $student->course()->attach($data['courses']);
        return $student;
    }
}
