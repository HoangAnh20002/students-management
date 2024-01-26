<?php

namespace App\Models;

use App\Http\Controllers\UserController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','department_id','student_code','email','birth_date'];

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Course(){
        return $this->belongsToMany(Course::class,'Student_Course','student_id','course_id');
    }
}
