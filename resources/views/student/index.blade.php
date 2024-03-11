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
    @if(session(('error')))
        <div class="alert alert-danger">
            {{session('error')}}
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
            width: 600px;
            text-align: center;
            float: right;
            margin-right: 20px;
        }
        .search_box {
            width: 90px;
        }
    </style>
    <form method="GET" action="{{ route('student.create') }}">
        <div class="d-flex mt-3 justify-content-around">
            <h2>Student List</h2>
            <div>
                <button class="bg-primary text-white btn" type="submit">Create</button>
            </div>
        </div>
    </form>

    <div class=" mt-3">
        <div class="search border bg-light shadow-sm py-2 px-5 rounded ml-4">
            <form action="{{ route('student.index') }}" method="GET">
                <div class="d-flex justify-content-around">
                    <div class="search_box">
                        <label for="result_from">Result From:</label>
                        <input type="number" id="result_from" class="form-control" name="result_from" min="0"
                        value="{{ old('result_from') ?? (request()->input('result_from') !== '' ? request()->input('result_from') : '') }}">
                    </div>
                    <div class="search_box">
                        <label for="result_to">Result To:</label>
                        <input type="number" id="result_to" class="form-control" name="result_to" min="0"
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
                </div>
                <button type="submit" class="btn btn-success mt-2">Search</button>
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
                                    {{$student->course->count('course')}}
                                </div>
                                <div>
                                    @if($student->course->count('course') < $student->department->course->count('course'))
                                        <button class="btn bg-success ml-3 text-white">Notice</button>
                                    @endif
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
    <script>
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
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
