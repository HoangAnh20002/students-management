@extends('layouts.home')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('departmentCreate')}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="m-5 h-100 border border-secondary bg-light p-3">
        <h2>Create Department</h2>
        <div class="p-3 w-auto">
            <form action="{{ route('department.store') }}" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <input type="name" class="form-control" id="name" name="name"
                           placeholder="name" required maxlength="255" value="{{ old('name') }}">
                    <label for="email">Name</label>
                </div>
                <button class="ml-5 mt-3 px-3 bg-primary text-white btn" type="submit">Submit</button>
                <a class="btn btn-secondary mt-3 ml-2" href="{{ url()->previous() }}">Cancel</a>
            </form>
        </div>
    </div>
@endsection

