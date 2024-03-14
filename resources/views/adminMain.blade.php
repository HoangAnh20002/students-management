<div class="disabled"{{$role = \App\Enums\Base::ADMIN}}></div>
@extends('layouts.home')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('home_ad')}}
    <h2>Welcome</h2>
@endsection
