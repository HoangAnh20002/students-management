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


Route::group(['middleware' => 'checkUserRole'], function () {
    Route::get('/AdminMain', function () {
        return view('AdminMain');
    })->name('AdminMain');
    Route::get('/StudentMain', [\App\Http\Controllers\StudentController::class, 'index'])->name('StudentMain');
});

Route::get('/login', [\App\Http\Controllers\LoginController::class,'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class,'login']);
