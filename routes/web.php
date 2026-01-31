<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SuperAdmin\AdminController as SuperAdminAdminController;
use App\Http\Controllers\SuperAdmin\AuthController as SuperAdminAuthController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});



Route::middleware('auth:superadmin')->prefix('super-admin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('super-admin.dashboard');
    })->name('dashboard');

    Route::get('/admins', [SuperAdminAdminController::class, 'index'])->name('admins.index');
    Route::post('/admins', [SuperAdminAdminController::class, 'store'])->name('admins.store');
    Route::get('/admins/{user}/edit', [SuperAdminAdminController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/{user}', [SuperAdminAdminController::class, 'update'])->name('admins.update');
    Route::patch('/admins/{user}/status', [SuperAdminAdminController::class, 'updateStatus'])->name('admins.status');
    Route::delete('/admins/{user}', [SuperAdminAdminController::class, 'destroy'])->name('admins.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



Route::middleware(['auth', 'ensure.permission'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('profile');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});





Route::get('/', function () {
    return view('website/home');
});
