<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mt-5">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <div class="border 3px; mx-auto" style="width: 500px;">
                <h3 class="text-center mt-3 font-weight-bold">Login</h3>
                <div class="form-group px-5">
                    <label for="name">Email</label>
                    <input type="email" class="form-control" name="email" id="email" maxlength="255" value="{{ old('email') ? old('email') : '' }}" required>
                </div>
                <div class="form-group px-5">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" maxlength="16" minlength="8" id="password" required>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
