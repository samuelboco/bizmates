<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    /**
     * For acquiring the Weather Data
     */
    public function get(Request $request, string $cityName, string $countryCode)
    {
        $response = Http::get('http://api.openweathermap.org/data/2.5/forecast', [
            'q' => "{$cityName},{$countryCode}",
            'appid' => env('API_OPENWEATHER_TOKEN'),
            'units' => 'metric'
        ])->json();

        return $response;
    }
}
