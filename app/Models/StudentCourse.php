<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StudentCourse extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table ='student_course';
    protected $fillable = ['student_id','course_id'];
}
