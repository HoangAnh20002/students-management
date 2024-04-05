<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


class UserController extends Controller
{
    public function index_ad(){;
        return view('adminMain');
    }


    public function fetchWeather()
    {
        $response = Http::get(env('API_WEATHER_URL') , [
            'q' => 'Hanoi',
            'appid' => env('API_WEATHER_KEY'),
        ]);
        return $response->json();
    }
}
