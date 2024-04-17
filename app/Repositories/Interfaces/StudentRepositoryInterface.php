<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface StudentRepositoryInterface extends BaseRepositoryInterface
{
    public function getWithRelationship($page);
    public function createWithUser(array $data);
    public function updateStudent(array $data, $id, $departmentId, $courseIds);
    public function deleteStudent($id);
    public function search ($request);
    public function updateAvatar($studentId, $avatar);
    public function getAllWithAverageScoreLessThanFive($chunkSize, $offset);


}

