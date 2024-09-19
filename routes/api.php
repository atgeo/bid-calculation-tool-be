<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PriceCalculationController;

Route::controller(RegisterController::class)->group(function () {
    //Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/calculate-price', [PriceCalculationController::class, 'calculate'])->middleware('auth:sanctum');
