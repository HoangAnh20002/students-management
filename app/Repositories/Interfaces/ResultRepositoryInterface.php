<?php
namespace App\Repositories\Interfaces;

interface ResultRepositoryInterface extends BaseRepositoryInterface
{
    public function updateMarks(array $resultIds, array $marks);
    public function getResultWithRelationship($page);
    public function checkExistedCourse($record);

}
