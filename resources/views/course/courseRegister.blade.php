@php
    use App\Enums\Base;
    $role = Base::STUDENT;
@endphp
@extends('layouts.home')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('courseRegister')}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2 class="text-center mt-3">Course Registration</h2>
    <table class="table mt-3">
        <form action="{{ route('courses.confirm') }}" method="POST">
            @csrf
            @if($courses->diff($registerCourse)->isNotEmpty())
                <div>
                    <button class="btn btn-primary float-right mt-3 mb-5 mr-3" type="submit">Register Selected Courses
                    </button>
                </div>
            @endif
            <thead>
            <tr>
                @if($courses->diff($registerCourse)->isNotEmpty())
                    <th style="width: 30px">
                        <input type="checkbox" id="check_all">
                    </th>
                @else
                    <th></th>
                @endif
                <th>Course</th>
                <th>Status</th>
                <th>Result</th>
            </tr>
            </thead>
            <tbody>
            @foreach($results as $result)
                <tr>
                    <td></td>
                    <td>{{$result->course->name}}</td>
                    <td>Already registered</td>
                    <td>{{$result->mark !== null ? $result->mark : 'N/A'}}</td>
                </tr>
            @endforeach
            @foreach(($courses->diff($registerCourse)) as $notRegisterCourse)
                <tr>
                    <td><input id="course_{{$notRegisterCourse->id}}" class="course_checkbox" type="checkbox"
                               name="course_ids[]" value="{{$notRegisterCourse->id}}"></td>
                    <td>{{$notRegisterCourse->name}}</td>
                    <td>Course is not registered</td>
                    <td>N/A</td>
                </tr>
            @endforeach
            </tbody>
        </form>
    </table>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('check_all').addEventListener('click', function () {
                var checkboxes = document.getElementsByClassName('course_checkbox');
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = this.checked;
                }
            });
        });
    </script>
@endsection


