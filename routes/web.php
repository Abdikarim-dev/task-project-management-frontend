<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::middleware('auth.session')->group(function (): void {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/theme', [ProfileController::class, 'updateTheme'])->name('profile.theme');

    Route::middleware('admin')->group(function (): void {
        Route::resource('projects', ProjectController::class);
        Route::resource('tasks', TaskController::class)->except(['show']);
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'show']);
        Route::patch('/users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
    });

    Route::get('/tasks/{task}', [TaskController::class, 'show'])
        ->name('tasks.show')
        ->whereNumber('task');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->name('tasks.update-status')
        ->whereNumber('task');
    Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my');
});
