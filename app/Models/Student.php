<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['user_id','department_id','student_code','image','date_of_birth'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function course(){
        return $this->belongsToMany(Course::class,'student_course','student_id','course_id')->withTimestamps();
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function result(){
        return $this->hasMany(Result::class);
    }
}
