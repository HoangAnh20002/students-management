<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentStudent extends Model
{
    use HasFactory;
    protected $table = "department_student";
    protected $fillable = ['department_id','student_id'];
}
