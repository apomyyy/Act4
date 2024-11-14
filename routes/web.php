<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController; // Make sure to import HomeController
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect(route('login'));
});

// Authentication routes
Auth::routes();

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// User Management Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
