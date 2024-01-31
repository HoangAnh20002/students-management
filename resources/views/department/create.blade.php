<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
 @include('layouts.header')
 @extends('layouts.footer')
 <div class="m-5">
     <h2>Create Department</h2>

     <div class="border p-3 w-auto">
         <form action="{{ route('department.store') }}" method="post">
             @csrf
             <label for="name">Name:</label>
             <input type="text" name="name" id="name" required><br/>
             <button class="ml-5 mt-3 px-3 bg-primary text-white" type="submit">Submit</button>
         </form>
     </div>

 </div>

 </body>
 </html>


