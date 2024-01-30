<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['name','full_name','password','role'];

    public function student(){
        return $this->hasMany(Student::class);
    }

}
