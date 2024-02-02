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

Route::get('/', [\App\Http\Controllers\CourseController::class, 'index']);

Route::group(['middleware' => 'adminCheck'], function () {
    Route::get('/adminMain',[\App\Http\Controllers\UserController::class,'index'])->name('adminMain');
});

Route::group(['middleware' => 'studentCheck'], function () {
    Route::get('/studentMain', [\App\Http\Controllers\StudentController::class, 'index'])->name('studentMain');
});

Route::get('/login', [\App\Http\Controllers\LoginController::class,'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class,'login']);
Route::get('/logout',[\App\Http\Controllers\LoginController::class,'logout'])->name('logout');

Route::resource('/department',\App\Http\Controllers\DepartmentController::class);
