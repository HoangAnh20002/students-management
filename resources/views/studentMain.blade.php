<div class="disabled"{{$role = 0}}></div>
@extends('layouts.home')
@section('content')
    @if(session(('error')))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('home_st')}}
    <h1>Welcome</h1>
@endsection
