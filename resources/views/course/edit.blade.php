@extends('layouts.home')
@section('content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('courseEdit', ['course' => $course]) }}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container h-100 mt-5 border border-secondary bg-light p-3">
        <h2>Edit Course</h2>
        <div class="mt-3">
            <div>
                <form action="{{ route('course.update', ['course' => $course->id]) }}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" value="{{ $course->id }}">
                    <div class="form-floating mb-3">
                        <input type="name" class="form-control" id="name" name="name"
                               placeholder="name" required maxlength="255" value="{{ old('name') ?? $course->name  }}">
                        <label for="email">Name</label>
                    </div>
                    <br/>
                    <div class="container-fluid h-100 bg-light text-dark">
                        <label for="department_select" class="mt-3">
                            Departments
                        </label>
                        <br>
                        <div>
                            <select class="mul-select w-100" multiple="true" id="department_select"
                                    name="departments[]">
                                @foreach($departments as $department)
                                    <option
                                        value="{{ $department->id }}" {{ in_array($department->id, old('departments', $course->department->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br/>
                    <button class="btn btn-primary mt-3" type="submit">Update</button>
                    <button type="button" class="mt-3 ml-2 bg-danger  rounded text-white btn" data-bs-toggle="modal"
                            data-bs-target="#exampleModal{{ $course->id }}">
                        Delete
                    </button>
                    <a class="btn btn-secondary mt-3 ml-2" href="{{ url()->previous() }}">Cancel</a>
                </form>
            </div>
            <div>
                <div class="modal fade" id="exampleModal{{ $course->id }}" tabindex="-1"
                     aria-labelledby="exampleModalLabel{{ $course->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel{{ $course->id }}">Delete
                                    Confirm </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <form action="{{ route('course.destroy', ['course' => $course->id]) }}"
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
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".mul-select").select2({
                placeholder: "Select course",
                tags: true,
                tokenSeparators: ['/', ',', ';', " "]
            });
        })
    </script>
@endsection

