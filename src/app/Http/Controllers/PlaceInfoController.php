<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlaceInfoController extends Controller
{
    
    /**
     * For acquiring the Place Information
     */
    public function get(Request $request, string $query, string $cityName, string $countryCode)
    {
        $response = Http::withHeaders([
            'Authorization' => env('API_FOURSQUARE_TOKEN'),
        ])->get('https://api.foursquare.com/v3/places/search', [
            'query' => "{$query}",
            'near' => "{$cityName}, {$countryCode}"
        ])->json();

        return $response;
    }
}
