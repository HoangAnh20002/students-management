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
                <div class="form-floating mb-3">
                    <input type="name" class="form-control" id="name" name="name"
                           placeholder="name" required maxlength="255" value="{{ old('name')}}">
                    <label for="email">Name</label>
                </div>
                <div class="h-100 bg-light text-dark">
                    <label for="department_select" class="mt-3 ">
                        Department:
                    </label>
                    <br>
                    <div class="form-group">
                        <select class="mul-select w-100" multiple="true" id="department_select" name="departments[]">
                            @foreach($departments as $department)
                                <option
                                    value="{{ $department->id }}" {{ in_array($department->id, old('department_ids', [])) ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button class="ml-5 mt-3 px-3 bg-primary text-white btn" type="submit">Submit</button>
                <a class="btn btn-secondary mt-3 ml-2" href="{{ url()->previous() }}">Cancel</a>
            </form>

        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".mul-select").select2({
                placeholder: "Select Department",
                tags: true,
                tokenSeparators: ['/',',',';'," "]
            });
        })
    </script>
@endsection

