<?php

use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;



Route::middleware('auth:api')
    ->prefix('dashboard')
    ->group(function () {

        Route::get('/summary', [DashboardController::class, 'summary']);
        Route::get('/monthly-earnings', [DashboardController::class, 'monthlyEarnings']);



    });
Route::post('/login', [AuthController::class, 'login']);

