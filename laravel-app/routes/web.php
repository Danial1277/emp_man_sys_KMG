<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// При заходе на главную страницу (/) сработает метод index в DashboardController
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');