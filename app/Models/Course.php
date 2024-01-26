<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function student(){
        return $this->belongsToMany(Student::class,'student_course','course_id','student_id');

    }
    public function result(){
        return $this->hasOne(Result::class);
    }
    public function department(){
        return $this->belongsToMany(Department::class,'department_course','course_id','department_id');
    }

}
