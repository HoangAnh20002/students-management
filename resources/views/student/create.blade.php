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
                <div class="row">
                    <div class="col-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                   placeholder="Full name" required maxlength="255" value="{{ old('full_name') }}">
                            <label for="full_name">Full name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="name@example.com" required maxlength="255" value="{{ old('email') }}">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Password"  minlength="8" maxlength="16">
                            <label for="password">Password</label>
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupFile01">Avatar</label>
                            <input type="file" class="form-control" id="inputGroupFile01" name="avatar"
                                   accept="image/png, image/jpeg" onchange="previewImage(this)">
                        </div>
                        <div id="imagePreview" class="mt-2 mb-2" style="display: none;">
                            <img id="preview" src="#" alt="Avatar Preview" style="max-width: 200px;">
                            <button type="button" class="btn btn-outline-secondary mt-2" onclick="removeImage()">Remove
                                Image
                            </button>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                   placeholder="Date of birth" required value="{{ old('date_of_birth')}}">
                            <label for="date_of_birth">Date of birth</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="mt-3" for="department_select">Departments:</label><br/>
                        <select class="form-select" id="department_select" name="department_id"
                                aria-label="Default select example">
                            @foreach($departments as $department)
                                <option
                                    value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <div class="container-fluid bg-light text-dark">
                                <label class="mt-3 ml-2 custom-label" for="courses_select">Courses:</label>
                            <div class="justify-content-center align-items-center mt-1 h-100">
                                <div class="col">
                                    <div class="form-group">
                                        <select class="mul-select w-100" id="courses_select" multiple="true" name="courses[]">
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" {{ in_array($course->id, old('courses', [])) ? 'selected' : '' }}>
                                                    {{ $course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="ml-5 mt-3 px-3 bg-primary text-white btn" type="submit">Submit</button>
                <a class="btn btn-secondary mt-3 ml-2" href="{{ url()->previous() }}">Cancel</a>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $(".mul-select").select2({
                placeholder: "Select course",
                tags: true,
                tokenSeparators: ['/',',',';'," "]
            });
        })
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

