<?php

use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;



Route::middleware('auth:api')
    ->prefix('dashboard')
    ->group(function () {

        Route::get('/summary', [DashboardController::class, 'summary']);
        Route::get('/accounting-earnings', [DashboardController::class, 'monthlyEarnings']);
        Route::get('/projects', [DashboardController::class, 'projects']);
        Route::get('/balance-chart', [DashboardController::class,'getBalanceChartData']);
        Route::get('/daily-schedule', [DashboardController::class, 'dailySchedule']);


    });
Route::post('/login', [AuthController::class, 'login']);

