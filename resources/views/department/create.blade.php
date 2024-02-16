@extends('layouts.home')
@section('content')
 <div class="m-5" style="height: 450px;">
     <h2>Create Department</h2>

     <div class="border p-3 w-auto ">
         <form action="{{ route('department.store') }}" method="post">
             @csrf
             <label for="name">Name:</label>
             <input type="text" name="name" id="name" required><br/>
             <button class="ml-5 mt-3 px-3 bg-primary text-white btn" type="submit">Submit</button>
         </form><button class="btn btn-secondary " onclick="history.back()">Cancel</button>
     </div>

 </div>
@endsection

