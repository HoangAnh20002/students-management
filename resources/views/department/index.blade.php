@include('layouts.header')
@extends('layouts.footer')
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <title>Department</title>
</head>

<body>
    <form method="" action="">
        <div>
            <h2 class="ml-5 mt-5">Department List</h2>
            <div>
                <button>Create</button>
            </div>
        </div>

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
                        <button><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="ml-2"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</html>
