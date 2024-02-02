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
            <form action="{{route('department.destroy',$department->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger mt-3">
                    Delete Department
                </button>
            </form>
        </div>

    </div>
@endsection

