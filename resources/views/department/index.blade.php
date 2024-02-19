@php
    use App\Enums\Base;
@endphp
@extends('layouts.home')
@section('content')
    @if($role == Base::Admin)
        {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('department')}}
    @else
        {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('department_st')}}
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

    <form method="GET" action="{{ route('department.create') }}">
        <div class="d-flex mt-3 justify-content-around">
            <h2>Department List</h2>
            @if($role == Base::Admin)
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
            @if($role == Base::Admin)
                <th scope="col">Action</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($departments as $department)
            <tr>
                <th scope="row">{{$department->id}}</th>
                <td>{{$department->name}}</td>
                @if($role == '1')
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('department.edit', ['department' => $department->id]) }}">
                                <button class="bg-success text-white btn">Edit</button>
                            </a>
                            <button type="button" class="ml-2 bg-danger text-white btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $department->id }}">
                                Delete
                            </button>
                            <div class="modal fade" id="exampleModal{{ $department->id }}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel{{ $department->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel{{ $department->id }}">
                                                Delete {{$department->name}}</h1>
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
                                                action="{{ route('department.destroy', ['department' => $department->id]) }}"
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
        {{ $departments->links('vendor.pagination.bootstrap-5') }}
    </div>

@endsection
