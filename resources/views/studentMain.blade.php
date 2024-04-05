<div class="disabled"{{$role = \App\Enums\Base::STUDENT}}></div>
@extends('layouts.home')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('home_st')}}
    @if(session(('error')))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div>
        <div class="d-flex mt-5 justify-content-around">
            <div>
                <h2 class="text-center">
                    Information
                </h2>
            </div>
            <div class="d-flex">
                <div class="mr-3">
                    @if($student->average_score !== null && $student->average_score !== 'N/A' && $student->average_score > 5 && $student->department->last()->course !== null)
                        <form method="GET" action="{{ route('departments.register') }}">
                            <button class="bg-primary text-white btn" type="submit">Department register</button>
                        </form>
                    @endif
                </div>
                <form method="GET" action="{{ route('courses.register') }}">
                    <button class="bg-primary text-white btn" type="submit">Course register</button>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-around m-5">
            <div class=" border shadow bg-light p-4 text-center" style="width: 390px">
                <div>
                    Current avatar:
                </div>
                <div class="rounded-circle mt-2">
                    @if($student->image)
                        <img class="h-25 w-25" src="{{ asset('storage/avatars/'.$student->image) }}" alt="Avatar">
                    @else
                        <p>No avatar</p>
                    @endif
                </div>
                <div>
                    <form action="{{ route('student.update.avatar', ['id' => $student->id]) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="input-group mb-3 mt-3" style="width: 350px;">
                            <label class="input-group-text" for="avatar">Choose new avatar</label>
                            <input type="file" class="form-control" id="avatar" name="avatar"
                                   accept="image/png, image/jpeg" onchange="previewImage(this)">
                        </div>
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="preview" src="#" alt="Avatar Preview" style="max-width: 150px;">
                            <button type="button" class="btn btn-outline-secondary mt-2" onclick="removeImage()">Remove
                                Image
                            </button>
                        </div>
                        <button class="mt-3 px-3 mb-5 bg-primary text-white btn" type="submit">Update</button>
                    </form>
                </div>
            </div>
            <div class=" border shadow bg-light p-4 ml-2" style="width: 600px">
                <div class="mt-3">Name : {{$user->full_name}}</div>
                <div class="mt-3">Email : {{$user->email}}</div>
                <div class="mt-3">Birth of date
                    : {{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</div>
                <div class="mt-3">Student code : {{$student->student_code}}</div>
            </div>
        </div>

        <script>
            function previewImage(input) {
                let preview = document.getElementById('preview');
                let imagePreview = document.getElementById('imagePreview');
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function removeImage() {
                let preview = document.getElementById('preview');
                let imagePreview = document.getElementById('imagePreview');
                let fileInput = document.getElementById('inputGroupFile01');

                preview.src = '#';
                imagePreview.style.display = 'none';
                fileInput.value = '';
            }
        </script>

@endsection
