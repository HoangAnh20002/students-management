@php
use App\Enums\Base;
 @endphp
@extends('layouts.home')
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if($role = Base::ADMIN)
        <div class="container mt-3 text-center ">
            <div class="d-flex justify-content-around mt-4">
                <div>
                    <a href="{{ route('export.results') }}" class="btn btn-primary">Export Results</a>
                </div>
                <form action="{{ route('results.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="csv_file" name="csv_file" accept=".csv">
                            <label class="custom-file-label" for="csv_file" id="csv_file_label">Choose CSV file</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Upload</button>
                            <button type="button" class="btn btn-danger" id="clear_file">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table">
            <h2 class="text-center my-4">Result</h2>
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Student Name</th>
                <th scope="col">Course</th>
                <th scope="col">Mark</th>
            </tr>
            </thead>
            @foreach($results as $result)
            <tbody>
            <tr>
                <th scope="row">{{$result->id}}</th>
                <td>{{$result->student == null ?  'N/A' :$result->student->user->full_name}}</td>
                <td>{{$result->course == null ?  'N/A' : $result->course->name}}</td>
                <td>{{$result->mark}}</td>
            </tr>
            </tbody>
            @endforeach
        </table>
        <div class="mb-5">
            {{ $results->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
    <script>
        document.getElementById('csv_file').addEventListener('change', function(e) {
            let fileName = e.target.files[0].name;
            let label = document.getElementById('csv_file_label');
            label.innerHTML = fileName;
        });
        document.getElementById('clear_file').addEventListener('click', function() {
            document.getElementById('csv_file').value = '';
            document.getElementById('csv_file_label').innerHTML = 'Choose CSV file';
        });
    </script>
@endsection
