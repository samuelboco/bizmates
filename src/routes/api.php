<?php

use App\Http\Controllers\PlaceInfoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\WeatherController;

Route::get("/weather/{cityName}/{countryCode}", [WeatherController::class, 'get']);
Route::get("/place-info/{query}/{cityName}/{countryCode}", [PlaceInfoController::class, 'get']);

