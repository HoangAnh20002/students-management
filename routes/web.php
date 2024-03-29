<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'adminCheck'], function () {
    Route::get('/adminMain',[\App\Http\Controllers\UserController::class,'index_ad'])->name('adminMain');
    Route::resource('/student',\App\Http\Controllers\StudentController::class);
});

Route::group(['middleware' => 'studentCheck'], function () {
    Route::get('/studentMain', [\App\Http\Controllers\UserController::class, 'index_st'])->name('studentMain');
});

Route::get('/login', [\App\Http\Controllers\LoginController::class,'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class,'login']);
Route::get('/logout',[\App\Http\Controllers\LoginController::class,'logout'])->name('logout');

Route::resource('/department',\App\Http\Controllers\DepartmentController::class);
Route::resource('/course',\App\Http\Controllers\CourseController::class);
