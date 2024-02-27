@php
use App\Enums\Base;
$role = Base::ADMIN;
 @endphp
@extends('layouts.home')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('studentCreate')}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="m-5 h-100  border border-secondary bg-light p-3">
        <h2>Create Student</h2>
        <div class="p-3 w-auto">
            <form action="{{ route('student.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div  class="row" >
                <div class="col-4">
                <label class="mt-2" for="name">Name:</label>
                <input type="text" name="name" id="name" required maxlength="255" value="{{ old('name') ? old('name') : '' }}"><br/>
                <label class="mt-2"  for="full_name">Full name:</label>
                <input type="text" name="full_name" id="full_name" required maxlength="255" value="{{ old('full_name') ? old('full_name') : '' }}"><br/>
                <label class="mt-2"  for="email">Email:</label>
                <input type="email" name="email" id="email" required maxlength="255" value="{{ old('email') ? old('email') : '' }}"><br/>
                <label class="mt-2"  for="password">Password:</label>
                <input type="password" name="password" id="password" required maxlength="16" minlength="8"><br/>
                <label class="mt-2"  for="student_code">Student Code:</label>
                <input type="text" name="student_code" id="student_code" required maxlength="255" value="{{ old('student_code') ? old('student_code') : '' }}"><br/>
                <label class="mt-2"  for="avatar">Avatar:</label></br>
                <input type="file" class="form-control-file" id="image" name="avatar" value="image">
                <label class="mt-2"  for="birth_date">Birth date:</label>
                <input type="date" name="birth_date" id="birth_date" required value="{{ old('birth_date') ? old('birth_date') : '' }}"><br/>
                </div>
                <div class="col-4">
                    <label class="mt-3">Departments:</label><br/>
                    @foreach($departments as $department)
                        <input type="radio" id="department_{{ $department->id }}" name="department_id" value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'checked' : '' }}>
                        <label for="department_{{ $department->id }}">{{ $department->name }}</label><br/>
                    @endforeach

                </div>
                    <div class="col-4">
                        <label class="mt-3">Courses:</label><br/>
                        @foreach($courses as $course)
                            <input type="checkbox" id="department_{{ $course->id }}" name="courses[]" value="{{ $course->id }}" {{ in_array($course->id, old('courses', [])) ? 'checked' : '' }}>
                            <label for="course_{{ $course->id }}">{{ $course->name }}</label><br/>
                        @endforeach
                    </div>
                </div>
                <button class="ml-5 mt-3 px-3 bg-primary text-white btn" type="submit">Submit</button>
                <a class="btn btn-secondary mt-3 ml-2" href="{{ url()->previous() }}">Cancel</a>

            </form>

        </div>
    </div>
@endsection

