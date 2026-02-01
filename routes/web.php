<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
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

    Route::resource('clients', ClientController::class);
    Route::resource('projects', ProjectController::class);
    Route::post('projects/add-member', [ProjectController::class, 'addMember'])->name('projects.addMember');
    Route::delete('projects/remove-member', [ProjectController::class, 'removeMember'])->name('projects.removeMember');

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

    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('profile');

    Route::resource('projects', ProjectController::class);
    Route::post('project/team', [ProjectController::class, 'addMember'])->name('projects.addMember');
    Route::delete('project/team', [ProjectController::class, 'removeMember'])->name('projects.removeMember');
    Route::get('projects/{project}/tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
    Route::post('projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');








    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});





Route::get('/', function () {
    return view('website/home');
});
