@php
    use App\Enums\Base;
    $role = Base::STUDENT;
@endphp
@extends('layouts.home')
@section('content')

    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('courseRegister')}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2 class="text-center mt-3">Department Registration</h2>
    <table class="table mt-3">
        <form action="{{ route('departments.confirm') }}" method="POST">
            @csrf
            <div>
                <button class="btn btn-primary float-right mt-3 mb-5 mr-3" type="submit">Register Selected Department
                </button>
            </div>
            <thead>
            <tr>
                <th></th>
                <th>Department</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($departments as $department)
                @php
                    $registered = false;
                    foreach ($registerDepartments as $registerDepartment) {
                        if ($department->id === $registerDepartment->id) {
                            $registered = true;
                            break;
                        }
                    }
                @endphp
                <tr>@if (!$registered)
                        <td>
                            <input id="department_{{ $department->id }}" class="department_radio" type="radio"
                                   name="department" value="{{ $department->id }}">
                        </td>
                    @else
                        <td></td>
                    @endif
                    <td><label for="department_{{ $department->id }}">{{ $department->name }}</label></td>
                    <td>
                        @if ($registered)
                            Already registered
                        @else
                            Department is not registered
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </form>
    </table>

@endsection


