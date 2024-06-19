<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function showWeather($city = 'Jakarta')
    {
        $apiKey = env('OPENWEATHERMAP_API_KEY');
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";
        $response = Http::get($url);

        if ($response->successful()) {
            $weatherData = $response->json();
            $iconUrl = "http://openweathermap.org/img/wn/{$weatherData['weather'][0]['icon']}@2x.png";

            return view('weather', [
                'city' => $weatherData['name'],
                'country' => $weatherData['sys']['country'],
                'temp' => $weatherData['main']['temp'],
                'humidity' => $weatherData['main']['humidity'],
                'wind' => $weatherData['wind']['speed'],
                'weatherDescription' => $weatherData['weather'][0]['description'],
                'iconUrl' => $iconUrl,
                // Placeholder data untuk hari berikutnya
                'icon0Url' => $iconUrl,
                'day0Temp' => $weatherData['main']['temp'],
                'icon1Url' => $iconUrl,
                'day1Temp' => $weatherData['main']['temp'],
                'icon2Url' => $iconUrl,
                'day2Temp' => $weatherData['main']['temp'],
                'icon3Url' => $iconUrl,
                'day3Temp' => $weatherData['main']['temp']
            ]);
        } else {
            return response()->json(['error' => 'Unable to fetch weather data'], 500);
        }
    }

    public function searchWeather(Request $request)
    {
        $city = $request->input('city');
        return $this->showWeather($city);
    }
}
