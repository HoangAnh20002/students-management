<?php
namespace App\Repositories;
use App\Enums\Base;
use App\Models\Department;
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
    public function getInfoStudentAndUser()
    {
        return $this->model->with('user')->get();
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
                'birth_date' => $data['birth_date'],
                'department_id' => $data['department_id'],
            ]);
        $student->student_code = "AP" . "-" . strtoupper(substr($department->name, 0, 2)) . "-" . $student->id;
        $student->save();
        $student->course()->attach($data['courses']);
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
            'role' => '0',
        ]);
        $student->update([
            'student_code' => $data['student_code'],
            'image' => $data['image'],
            'birth_date' => $data['birth_date'],
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
}
