<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InitController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('init')->controller(InitController::class)->group(function () {
    Route::get('migrations', 'migrations');
    Route::get('models', 'models');
    Route::get('controllers', 'controllers');
    Route::get('factories', 'factories');
Route::get('seeders', 'seeders');
});

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});