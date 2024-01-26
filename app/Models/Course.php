<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function Student(){
        return $this->belongsToMany(Student::class,'Student_Course','Course_id','Student_id');

    }
    public function Result(){
        return $this->hasOne(Result::class);
    }
    public function Department(){
        return $this->belongsToMany(Department::class,'Department_Course','course_id','department_id');
    }

}
