<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['student_id','course_id','mark'];
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function student(){
        return $this->belongsTo(Student::class);
    }
}
