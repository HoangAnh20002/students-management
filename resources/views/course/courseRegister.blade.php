@php
    use App\Enums\Base;
    $role = Base::STUDENT;
@endphp
@extends('layouts.home')
@section('content')
    @php
        $register = false;
    @endphp
    @foreach ($courses as $course)
        @if (!$registerCourse->contains($course))
            @php
                $register = true;
            @endphp
            @break
        @endif
    @endforeach
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
            <div>
                <button class="btn btn-primary float-right mt-3 mb-5 mr-3" type="submit">Register Selected Courses
                </button>
            </div>
            <thead>
            <tr>
                @if($register)
                    <th style="width: 30px">
                        <input type="checkbox" id="check_all">
                    </th>
                @endif
                <th>Course</th>
                <th>Status</th>
                <th>Result</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($courses as $course)
                <tr>
                    @if($register)
                        <td>
                            @if (!$registerCourse->contains($course))
                                <input id="course_{{ $course->id }}" class="course_checkbox" type="checkbox"
                                       name="course_ids[]" value="{{ $course->id }}">
                            @endif
                        </td>
                    @endif
                    <td><label for="course_{{$course->id}}">{{ $course->name }}</label></td>
                    <td>
                        @if ($registerCourse->contains($course))
                            Already registered
                        @else
                            Course is not registered
                        @endif
                    </td>
                    <td>
                        @if ($registerCourse->contains($course))
                            {{ optional($course->result)->mark != null ? $course->result->mark : 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
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


