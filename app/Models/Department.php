<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name'];
    public function course(){
        return $this->belongsToMany(Course::class,'department_course','department_id','course_id')->withTimestamps();
    }
    public function student(){
        return $this->belongsToMany(Student::class,'department_student','department_id','student_id')->withTimestamps();
    }
}
