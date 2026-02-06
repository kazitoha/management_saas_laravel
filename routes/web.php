<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\MyTaskController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\SuperAdmin\AdminController as SuperAdminAdminController;
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

    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::post('projects/add-member', [ProjectController::class, 'addMember'])->name('projects.addMember');
    Route::delete('projects/remove-member/{id}', [ProjectController::class, 'removeMember'])->name('projects.removeMember');

    Route::get('projects/{project}/tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
    Route::post('projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');

    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::post('tasks/{task}/assign-to-me', [TaskController::class, 'assignToMe'])->name('tasks.assignToMe');
    Route::post('tasks/{task}/checklist', [TaskController::class, 'addChecklistItem'])->name('tasks.checklist.store');
    Route::patch('tasks/checklist/{item}', [TaskController::class, 'toggleChecklistItem'])->name('tasks.checklist.toggle');
    Route::delete('tasks/checklist/{item}', [TaskController::class, 'deleteChecklistItem'])->name('tasks.checklist.destroy');

    // my tasks route
    Route::get('/my-tasks', [MyTaskController::class, 'index'])->name('my-tasks');

    // attendance routes
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');



    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('profile');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});





Route::get('/', function () {
    return view('website/home');
});
