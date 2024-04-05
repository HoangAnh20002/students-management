@php
    use App\Enums\Base;
    $role = Base::ADMIN;
@endphp
@extends('layouts.home')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('student')}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger">
            @if(is_array(session('error')))
                @foreach(session('error') as $error)
                    <p>{{ $error }}</p>
                @endforeach
            @else
                <p>{{ session('error') }}</p>
            @endif
        </div>
    @endif
    <style>
        .name {
            max-width: 150px;
            color: #0079c1;
            height: 2em;
            text-overflow: ellipsis;
            cursor: pointer;
            word-break: break-all;
            overflow: hidden;
            white-space: nowrap;
        }

        .name:hover {
            overflow: visible;
            white-space: normal;
            height: auto;
        }

        .table-container:hover {
            cursor: grabbing;
        }

        .search {
            text-align: center;
        }

        .search_box {
            width: 90px;
        }
        .modal-content1 {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
        }
        .modal-content{
            z-index: 0;
        }
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none;
        }

        .modal.show + #overlay {
            display: block;
        }

        #loadingModal.modal.show {
            z-index: 10000;
        }
    </style>
    <!-- Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content1">
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>
    <div id="overlay" ></div>
    <div id="page-wrapper">
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel1">Quick Create</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createStudentForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="p-3 w-auto">
                            <div id="message" class="p-3 mb-2" style="display: none;"></div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="full_name" name="full_name"
                                               placeholder="Full name" required maxlength="255"
                                               value="{{ old('full_name') }}">
                                        <label for="full_name">Full name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="name@example.com" required maxlength="255"
                                               value="{{ old('email') }}">
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="password" name="password"
                                               placeholder="Password" minlength="8" maxlength="16">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupFile01">Avatar</label>
                                        <input type="file" class="form-control" id="inputGroupFile01" name="avatar"
                                               accept="image/png, image/jpeg" onchange="previewImage(this)">
                                    </div>
                                    <div id="imagePreview" class="mt-2 mb-2" style="display: none;">
                                        <img id="preview" src="#" alt="Avatar Preview" style="max-width: 200px;">
                                        <button type="button" class="btn btn-outline-secondary mt-2"
                                                onclick="removeImage()">Remove
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
                                    <div class="container-fluid text-dark">
                                        <label class="mt-3 ml-2 custom-label" for="courses_select">Courses:</label>
                                        <div class="justify-content-center align-items-center mt-1 h-100">
                                            <div class="col">
                                                <div class="form-group">
                                                    <select class="mul-select" id="courses_select" multiple="true"
                                                            name="courses[]">
                                                        @foreach($courses as $course)
                                                            <option
                                                                value="{{ $course->id }}" {{ in_array($course->id, old('courses', [])) ? 'selected' : '' }}>
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
                            <button class="ml-5 mt-3 px-3 bg-primary text-white btn">Submit</button>
                            <a class="btn btn-secondary mt-3 ml-2 text-white" data-bs-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form method="GET" action="{{ route('student.create') }}">
        <div class="d-flex mt-3 justify-content-around">
            <h2>Student List</h2>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                    Quirk Create
                </button>
                <button class="bg-primary text-white btn ml-2" type="submit">Create</button>
            </div>
        </div>
    </form>
    <div class=" mt-3">
        <div class=" container search border bg-light shadow-sm py-2 px-5 rounded ml-4">
            <form action="{{ route('student.index') }}" method="GET">
                <div class="d-flex justify-content-around pl-5 py-2">
                    <div class="search_box">
                        <label for="result_from">Result From:</label>
                        <input type="number" step="any" id="result_from" class="form-control" name="result_from" min="0"
                               value="{{ old('result_from') ?? (request()->input('result_from') !== '' ? request()->input('result_from') : '') }}">
                    </div>
                    <div class="search_box">
                        <label for="result_to">Result To:</label>
                        <input type="number" step="any" id="result_to" class="form-control" name="result_to" min="0"
                               value="{{ old('result_to') ?? (request()->input('result_to') !== '' ? request()->input('result_to') : '') }}">
                    </div>
                    <div class="search_box">
                        <label for="age_from">Age From:</label>
                        <input type="number" id="age_from" class="form-control" name="age_from" min="0"
                               value="{{ old('age_from') ?? (request()->input('age_from') !== '' ? request()->input('age_from') : '') }}">
                    </div>
                    <div class="search_box">
                        <label for="age_to">Age To:</label>
                        <input type="number" id="age_to" class="form-control" name="age_to" min="0"
                               value="{{ old('age_to') ?? (request()->input('age_to') !== '' ? request()->input('age_to') : '') }}">
                    </div>
                    <button type="submit" class="btn btn-success mt-4">Search</button>
                </div>
            </form>
        </div>

    </div>
    <div class="table-container">
        <div class="table-responsive">
            <table class="table mt-3 shadow border w-100" id="custom-table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Student Code</th>
                    <th scope="col">Average score</th>
                    <th scope="col">Image</th>
                    <th scope="col">D.O.B</th>
                    <th scope="col">Course registered</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <th scope="row">{{$student->id}}</th>
                        <td class="name">{{$student->user->full_name}}</td>
                        <td class="name">{{$student->user->email}}</td>
                        <td>{{$student->student_code}}</td>
                        <td>
                            {{$student->average_score ?? 'N/A'}}
                        </td>
                        <td style="max-width: 200px">@if($student->image)
                                <img class="h-50 w-50" src="{{ asset('storage/avatars/'.$student->image) }}"
                                     alt="Avatar">
                            @else
                                <p>No avatar</p>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex">
                                <div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#studentModal{{ $student->id }}">
                                        {{$student->course->count('course')}}
                                    </button>
                                    <div class="modal fade" id="studentModal{{ $student->id }}" tabindex="-1"
                                         aria-labelledby="studentModalLabel{{ $student->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="studentModalLabel{{ $student->id }}">
                                                        Courses for Student : {{ $student->user->full_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Course</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($student->course as $course_st)
                                                            <tr>
                                                                <td>{{ $course_st->id }}</td>
                                                                <td>{{ $course_st->name }}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @if($student->course->count('course') < $student->department->last()->course->count('course'))
                                        <form action="{{ route('student.send_email_notice') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <button type="submit" class="btn bg-success ml-3 text-white">Notice</button>
                                        </form>
                                    @endif
                                </div>
                                <div>
                                    <form action="{{ route('result.show', ['result' => $student->id]) }}" method="GET">
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                        <button type="submit" class="btn btn-primary ml-3">Detail</button>
                                    </form>
                                </div>
                            </div>

                        <td>
                            <div class="d-flex">
                                <a href="{{ route('student.edit', ['student' => $student->id]) }}">
                                    <button class="bg-success text-white btn">Edit</button>
                                </a>
                                <button type="button" class="ml-2 bg-danger text-white btn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $student->id }}">
                                    Delete
                                </button>
                                <div class="modal fade" id="exampleModal{{ $student->id }}" tabindex="-1"
                                     aria-labelledby="exampleModalLabel{{ $student->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel{{ $student->id }}">
                                                    Delete {{$student->name}}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <form
                                                    action="{{ route('student.destroy', ['student' => $student->id]) }}"
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
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mb-5 mt-5">
        {{ $students->appends(request()->query())->setPath(route('student.index'))->links('vendor.pagination.bootstrap-5') }}
    </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#createStudentForm').submit(function (event) {
                event.preventDefault();
                $('#loadingModal').modal('show');
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('student.store') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response)
                        if (response.status === 'success') {
                            $('#exampleModal1').modal('hide');
                            location.reload();
                        } else {
                            $("#message").removeClass("alert-success").addClass("alert-danger").text(response.message).show();
                        }
                    },
                    error: function (xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            $("#message").removeClass("alert-success").addClass("alert-danger").text(xhr.responseJSON.message).show();
                        } else {
                            $("#message").removeClass("alert-success").addClass("alert-danger").text("An error occurred while processing your request.").show();
                        }
                    }
                });
            });
        });


        $(document).ready(function () {
            var isMouseDown = false,
                startX,
                startScrollLeft;
            $(".table-responsive").mousedown(function (event) {
                isMouseDown = true;
                startX = event.pageX - $(this).offset().left;
                startScrollLeft = $(this).scrollLeft();
            }).mousemove(function (event) {
                if (isMouseDown) {
                    var newX = event.pageX - $(this).offset().left;
                    $(this).scrollLeft(startScrollLeft - newX + startX);
                }
            }).mouseup(function () {
                isMouseDown = false;
            });
        });
        $(document).ready(function () {
            $(".mul-select").select2({
                placeholder: "Select course",
                tags: true,
                tokenSeparators: ['/', ',', ';', " "]
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
        document.getElementById('overlay').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
@endsection
@stack('studentIndexScript')
