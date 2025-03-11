<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 

Route::get('/', function() {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');