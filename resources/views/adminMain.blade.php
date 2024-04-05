<div class="disabled"{{$role = \App\Enums\Base::ADMIN}}></div>
@extends('layouts.home')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('home_ad')}}
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card" style="color: #4B515D; border-radius: 35px;">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <h6 class="flex-grow-1"><span id="city"></span></h6>
                                <h6>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</h6>
                            </div>
                            <div class="d-flex flex-column text-center mt-5 mb-4">
                                <h6 class="display-4 mb-0 font-weight-bold" style="color: #1C2331;"><span
                                        id="temperature"></span> <h5>Celsius</h5></h6>
                                <span class="small" style="color: #868B94"><span id="weather"></span></span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1" style="font-size: 1rem;">
                                    <div><i class="fas fa-wind fa-fw" style="color: #868B94;"></i> <span
                                            class="ms-1"> <span id="wind-speed"></span> km/h</span></div>
                                    <div><i class="fas fa-tint fa-fw" style="color: #868B94;"></i> <span
                                            class="ms-1"> <span id="humidity"></span>%</span>
                                    </div>
                                </div>
                                <div>
                                    <img id="weather-image" width="100px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function fetchWeather() {
            $.ajax({
                url: "{{route('fetchWeather')}}",
                method: 'GET',
                success: function (data) {
                    const city = data.name;
                    const temperature = (data.main.temp - 273.15).toFixed(2);
                    const humidity = data.main.humidity;
                    const windSpeed = data.wind.speed;
                    const weather = data.weather[0].main;

                    document.getElementById('city').innerText = city;
                    document.getElementById('temperature').innerText = temperature;
                    document.getElementById('humidity').innerText = humidity;
                    document.getElementById('wind-speed').innerText = windSpeed;
                    const weatherElement = document.getElementById('weather-image');
                    if (weather === 'Clouds') {
                        weatherElement.src = 'https://cdn-icons-png.flaticon.com/512/4834/4834559.png';
                    }
                    if (weather === 'Rain') {
                        weatherElement.src = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmI9Ol9Ii0TXCINmwCAnWeLymhZbXl7LzprppXoDDdvIAZ-pPLS4PzfTBH4A2qKIqpJwk&usqp=CAU';
                    }
                    if (weather === 'Snow') {
                        weatherElement.src = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZJJ8bTqNivgQNB2oagNE-TlewMnwfKj5GFcrG0hIPWQgoHS3mtE7kodx0-AXeYTjURCg&usqp=CAU';
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching weather data:', error);
                }
            });
        }
        fetchWeather();
        setInterval(fetchWeather, 5000);
    </script>
@endsection

