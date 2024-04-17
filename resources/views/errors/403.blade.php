@php
$role =  \App\Enums\Base::STUDENT;
 @endphp
@extends('layouts.home')
@section('content')
    <style>
        @import url(https://fonts.googleapis.com/css?family=Raleway:700);

        a {
            color: #EE4B5E !important;
            text-decoration:none;
        }
        a:hover {
            color: #FFFFFF !important;
            text-decoration:none;
        }

        .text-wrapper {
            margin:20px;
            background-color: aliceblue;
            border: 1px darkgray;
            padding-bottom: 150px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .title {
            font-size: 5em;
            font-weight: 700;
            color: #EE4B5E;
        }

        .subtitle {
            font-size: 40px;
            font-weight: 700;
            color: #1FA9D6;
        }
        .buttons {
            margin: 70px;
            font-weight: 700;
            border: 2px solid #EE4B5E;
            text-decoration: none;
            padding: 15px;
            text-transform: uppercase;
            color: #EE4B5E;
            border-radius: 26px;
            transition: all 0.2s ease-in-out;
            display: inline-block;
        }
        .buttons:hover {
            background-color: #EE4B5E;
            color: white;
            transition: all 0.2s ease-in-out;
        }

    </style>
    <div class="text-wrapper">
    <div class="title" data-content="404">
        ACCESS DENIED
    </div>

    <div class="subtitle">
        Oops, You don't have permission to access this page.
    </div>

    <div class="buttons">
        <a class="button" href="{{route('studentMain')}}">Go to homepage</a>
    </div>
    </div>
@endsection
