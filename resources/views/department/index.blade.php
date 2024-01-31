
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <title>Department</title>
</head>

<body>
@include('layouts.header')
@extends('layouts.footer')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="GET" action="{{ route('department.create') }}">
    <div class="d-flex justify-content-around">
        <h2 class="ml-5 mt-5">Department List</h2>
        <div>
            <button class="m-5 w-75 h-25 bg-primary text-white border-primary" type="submit">Create</button>
        </div>
    </div>
</form>

<table class="table m-5 border" style="width: 90%">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($departments as $department)
        <tr>
            <th scope="row">{{$department->id}}</th>
            <td>{{$department->name}}</td>
            <td>
                <div class="d-flex">
                    <a href="{{ route('department.edit', ['department' => $department->id]) }}">
                        <button class="bg-success text-white">Edit</button>
                    </a>
                    <button type="button" class="ml-2 bg-danger text-white " data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Delete
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="{{route('department.destroy',['department' => $department->id])}}"><button type="button" class="btn btn-primary">Delete</button></a>
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

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>
