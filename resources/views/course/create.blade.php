@extends('layouts.home')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('courseCreate')}}
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
        <h2>Create Course</h2>
        <div class="p-3 w-auto">
            <form action="{{ route('course.store') }}" method="post">
                @csrf
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required maxlength="255"><br/>

                <label class="mt-3">Departments:</label><br/>
                @foreach($departments as $department)
                    <input type="checkbox" id="department_{{ $department->id }}" name="departments[]" value="{{ $department->id }}">
                    <label for="department_{{ $department->id }}">{{ $department->name }}</label><br/>
                @endforeach

                <button class="ml-5 mt-3 px-3 bg-primary text-white btn" type="submit">Submit</button>
                <a class="btn btn-secondary mt-3 ml-2" href="{{ url()->previous() }}">Cancel</a>
            </form>

        </div>
    </div>
@endsection

