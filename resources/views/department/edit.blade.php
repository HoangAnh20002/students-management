@extends('layouts.home')
@section('content')
    <div class="container " style="margin-bottom: 315px" >
        <h2 class="mt-5">Edit Department</h2>
        <div class="mt-3">
            <form action="{{ route('department.update', $department->id) }}" method="post">
                @csrf
                @method('put')
                <label for="name">Department Name:</label>
                <input type="text" name="name" value="{{ $department->name }}" required>
                <br/>
                <button class="btn btn-primary mt-3" type="submit">Update Department</button>
            </form>
            <button type="button" class="mt-2 bg-danger px-3 py-1 rounded text-white" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $department->id }}">
                Delete
            </button>
            <div class="modal fade" id="exampleModal{{ $department->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $department->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel{{ $department->id }}">Delete {{ $department->name }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete {{ $department->name }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form action="{{ route('department.destroy', ['department' => $department->id]) }}" method="POST">
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
@endsection

