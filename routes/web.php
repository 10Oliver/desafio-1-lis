<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::resource('incomes', IncomeController::class);

    Route::resource('expenses', ExpenseController::class);

    Route::resource('accounts', AccountController::class);

    Route::resource('categories', CategoryController::class);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});
