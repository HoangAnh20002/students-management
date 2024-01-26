<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function Course(){
        return $this->belongsToMany(Course::class,'Department_Course','department_id','course_id');
    }
}
