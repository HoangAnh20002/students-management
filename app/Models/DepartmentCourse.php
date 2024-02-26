<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentCourse extends Model
{
    use HasFactory;

    protected $table = "department_course";

    protected $fillable = ['department_id','course_id'];
}
