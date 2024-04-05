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
        <h2>Edit Student</h2>
        <div class="p-3 w-auto">
            <form action="{{ route('student.update',['student' => $student->id]) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-4">
                        <input type="hidden" name="id" value="{{ $student->id }}">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                   placeholder="Full name" required maxlength="255"
                                   value="{{ old('full_name') ?? $student->user->full_name }}">
                            <label for="full_name">Full name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                   readonly maxlength="255" value="{{ old('email') ?? $student->user->email }}">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Password" maxlength="16" minlength="8">
                            <label for="password">Password</label>
                        </div>
                        <div>
                            <div>Current avatar:</div>
                            @if($student->image)
                                <img class="h-50 w-50" src="{{ asset('storage/avatars/'.$student->image) }}" alt="Avatar">
                            @else
                                <p>No avatar</p>
                            @endif
                            <br>
                            <div class="input-group mb-3 mt-3">
                                <label class="input-group-text" for="avatar">Choose new avatar</label>
                                <input type="file" class="form-control" id="avatar" name="avatar"
                                       accept="image/png, image/jpeg" onchange="previewImage(this)">
                            </div>
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="preview" src="#" alt="Avatar Preview" style="max-width: 200px;">
                                <button type="button" class="btn btn-outline-secondary mt-2" onclick="removeImage()">
                                    Remove Image
                                </button>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                   placeholder="Birth date" required
                                   value="{{ old('date_of_birth') ?? $student->date_of_birth }}">
                            <label for="date_of_birth">Birth date</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="mt-3" for="department_id">Department:</label><br/>
                        <select id="department_id" name="department_id" class="form-select" required>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ (old('department_id', $student->department->last()->id) == $department->id) ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                            <div class="container-fluid h-100 bg-light text-dark">
                                    <label class="mt-3" for="course_id">Courses:</label>
                                <br>
                                <div class="justify-content-center align-items-center h-100">
                                        <div class="form-group">
                                            <select id="course_id" class="mul-select" multiple="true" style="width:120px" name="courses[]">
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}" {{ in_array($course->id, old('courses', $student->course->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                        {{ $course->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                            </div>
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
        $(document).ready(function(){
            $(".mul-select").select2({
                placeholder: "Select course",
                tags: true,
                tokenSeparators: ['/',',',';'," "]
            });
        })
        document.getElementById('password').addEventListener('change', function () {
            var passwordInput = this.value;
            if (passwordInput.trim() !== '') {

            } else {
                this.value = '';
            }
        });

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
