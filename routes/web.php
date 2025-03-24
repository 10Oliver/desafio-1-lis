<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Illuminate\Support\Facades\Auth;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/register-first-step', [AuthController::class, 'checkFirstStep'])->name('register.first');
Route::post('/register-second-step', [AuthController::class, 'checkSecondStep'])->name('register.second');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('/two-factor-challenge', function () {
    return view('auth.two-factor-challenge');
})->name('two-factor.login');

Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
->middleware('guest')
->name('two-factor.login');

Route::middleware('auth')->group(function () {
    /* Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
*/
Route::get('/', [DashboardController::class, 'showReport'])->name('dashboard');


    Route::resource('incomes', IncomeController::class);

    Route::resource('expenses', ExpenseController::class);

    Route::resource('accounts', AccountController::class);

    Route::resource('categories', CategoryController::class);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'editIndex'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'updateUserData'])->name('profile.edit');

    Route::get('/profile/change-password', [ProfileController::class, 'showPasswordView'])->name('profile.changePassword');
    Route::get('/profile/two-factor', [ProfileController::class, 'showTwoFactor'])->name('profile.twoFactor');

    Route::get("/logout", [AuthController::class, 'logout'])->name('auth.logout');

    // Two factor views
    Route::get('/two-factor-settings', [AuthController::class, 'active2FA'])->name('two-factor.settings');

    // Two factor methods

    Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store']);
    Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy']);

    Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show']);
    Route::get('/user/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show']);

    Route::post('/user/two-factor-confirmation', [TwoFactorAuthenticatedSessionController::class, 'store']);
    Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store']);
});
