<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', fn (Request $request) => $request->user())->middleware('auth:sanctum');

Route::as('api.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('cars', CarController::class);
    });
});
