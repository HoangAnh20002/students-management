<?php

namespace App\Http\Controllers;

use App\Models\User;


class UserController extends Controller
{
    public function index_ad(){
        return view('adminMain');
    }
    public function index_st(){
        return view('studentMain');
    }
}
