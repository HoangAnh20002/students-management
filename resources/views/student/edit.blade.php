@php
    use App\Enums\Base;
    $role = Base::ADMIN;
@endphp
@extends('layouts.home')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('studentEdit', ['student' => $student])}}
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
            <form action="{{ route('student.update',['student' => $student->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div  class="row" >
                    <div class="col-4">
                        <input type="hidden" name="id" value="{{ $student->id }}">
                        <label class="mt-2"  for="full_name">Full name:</label>
                        <input type="text" name="full_name" id="full_name" value="{{$student->user->full_name}}" required maxlength="255" {{ old('full_name') ? old('full_name') : '' }}><br/>
                        <label class="mt-2"  for="email">Email:</label>
                        <input type="email" name="email" id="email" value="{{$student->user->email}}" readonly maxlength="255" {{ old('email') ? old('email') : '' }}><br/>
                        <label class="mt-2"  for="password">Password:</label>
                        <input type="password" name="password" id="password" required maxlength="16" minlength="8"><br/>
                        <label class="mt-2"  for="student_code">Student Code:</label>
                        <input type="text" name="student_code" id="student_code" value="{{$student->student_code}}" required maxlength="255" {{ old('student_code') ? old('student_code') : '' }}><br/>
                        <div class="mt-2">
                            <div>Current avatar:</div>
                        @if($student->image)
                            <img class="h-50 w-50" src="{{ asset('avatars/' . $student->image) }}" alt="Avatar">
                        @else
                            <p>No avatar</p>
                        @endif
                            <br/><div class="input-group mb-3 mt-3">
                                <label class="input-group-text" for="inputGroupFile01">Choose new avatar</label>
                                <input type="file" class="form-control" id="inputGroupFile01" name="avatar" accept="image/png, image/jpeg" onchange="previewImage(this)">
                            </div>
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="preview" src="#" alt="Avatar Preview" style="max-width: 200px;">
                                <button type="button" class="btn btn-outline-secondary mt-2" onclick="removeImage()">Remove Image</button>
                            </div>
                        </div>
                        <label class="mt-3"  for="birth_date">Birth date:</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{$student->birth_date}}" required {{ old('birth_date') ? old('birth_date') : '' }}><br/>
                    </div>
                    <div class="col-4">
                        <label class="mt-3">Departments:</label><br/>
                        @foreach($departments as $department)
                            <input type="radio" id="department_{{ $department->id }}" name="department_id" value="{{ $department->id }}" {{ $student->department_id == $department->id ? 'checked' : '' }}>
                            <label for="department_{{ $department->id }}">{{ $department->name }}</label><br/>
                        @endforeach
                    </div>
                    <div class="col-4">
                        <label class="mt-3">Courses:</label><br/>
                        @foreach($courses as $course)
                            <input type="checkbox" id="course_{{ $course->id }}" name="courses[]" value="{{ $course->id }}" {{ $student->course->contains('id', $course->id) ? 'checked' : '' }}>
                            <label for="course_{{ $course->id }}">{{ $course->name }}</label><br/>
                        @endforeach
                    </div>

                </div>
                <button class="ml-5 mt-3 px-3 bg-primary text-white btn" type="submit">Update</button>
                <button type="button" class="mt-3 ml-2 bg-danger  rounded text-white btn" data-bs-toggle="modal"
                        data-bs-target="#exampleModal{{ $student->id }}">
                    Delete
                </button>
                <a class="btn btn-secondary mt-3 ml-2" href="{{ url()->previous() }}">Cancel</a>
            </form>
        </div>
        <div>
            <div class="modal fade" id="exampleModal{{ $student->id }}" tabindex="-1"
                 aria-labelledby="exampleModalLabel{{ $student->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel{{ $student->id }}">Delete
                                Confirm </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form action="{{ route('student.destroy', ['student' => $student->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            var preview = document.getElementById('preview');
            var imagePreview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            var preview = document.getElementById('preview');
            var imagePreview = document.getElementById('imagePreview');
            var fileInput = document.getElementById('inputGroupFile01');

            preview.src = '#';
            imagePreview.style.display = 'none';
            fileInput.value = '';
        }
    </script>
@endsection

