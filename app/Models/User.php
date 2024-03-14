<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['full_name','email','password','role'];

    public function student(){
        return $this->hasMany(Student::class);
    }

}
