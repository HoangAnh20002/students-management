@php
    use App\Enums\Base;
@endphp
@extends('layouts.home')
@section('content')
    @if($role == Base::ADMIN)
        {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('course')}}
    @else
        {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('course_st')}}
    @endif
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

    <form method="GET" action="{{ route('course.create') }}">
        <div class="d-flex mt-3 justify-content-around">
            <h2>Course List</h2>
            @if($role == Base::ADMIN)
                <div>
                    <button class="bg-primary text-white btn" type="submit">Create</button>
                </div>
            @endif
        </div>
    </form>
    <table class="table mt-3 shadow border w-100">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            @if($role == Base::ADMIN)
                <th scope="col">Action</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($courses as $course)
            <tr>
                <th scope="row">{{$course->id}}</th>
                <td>{{$course->name}}</td>
                @if($role == Base::ADMIN)
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('course.edit', ['course' => $course->id]) }}">
                                <button class="bg-success text-white btn">Edit</button>
                            </a>
                            <button type="button" class="ml-2 bg-danger text-white btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $course->id }}">
                                Delete
                            </button>
                            <div class="modal fade" id="exampleModal{{ $course->id }}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel{{ $course->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel{{ $course->id }}">
                                                Delete {{$course->name}}</h1>
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
                                                action="{{ route('course.destroy', ['course' => $course->id]) }}"
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
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mb-5">
        {{ $courses->links('vendor.pagination.bootstrap-5') }}
    </div>

@endsection
