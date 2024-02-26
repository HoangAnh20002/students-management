@extends('layouts.home')
@section('content')
    {{$role = '1'}}
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('studentCreate')}}
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
        <h2>Create Student</h2>
        <div class="p-3 w-auto">
            <form action="{{ route('student.store') }}" method="post">
                @csrf
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required maxlength="255"><br/>
                <label for="name">Full name:</label>
                <input type="text" name="name" id="full_name" required maxlength="255"><br/>
                <label for="name">Email:</label>
                <input type="email" name="name" id="email" required maxlength="255"><br/>
                <label for="name">Student Code:</label>
                <input type="text" name="student_code" id="student_code" required maxlength="255"><br/>
                <label for="avatar">Avatar:</label></br>
                <input type="file" class="form-control-file" id="avatar" name="avatar" value="avatar">
                <label for="name">Birth date:</label>
                <input type="date" name="birth_date" id="birth_date" required><br/>

                <button class="ml-5 mt-3 px-3 bg-primary text-white btn" type="submit">Submit</button>
                <a class="btn btn-secondary mt-3 ml-2" href="{{ url()->previous() }}">Cancel</a>
            </form>

        </div>
    </div>
@endsection

