<?php
/**
 * TEMPEL isi file ini ke dalam routes/web.php yang sudah ada
 * (jangan replace file, cukup gabungkan use-statement + route groupnya).
 */

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TaskMemberController;
use App\Http\Controllers\Admin\UserController;

// SRS-002: login/logout
Route::get('/login', [LoginController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // SRS-006: kolaborasi tugas
    Route::post('/tasks/{task}/members', [TaskMemberController::class, 'store'])->name('tasks.members.store');
    Route::delete('/tasks/{task}/members/{member}', [TaskMemberController::class, 'destroy'])->name('tasks.members.destroy');
    Route::patch('/tasks/{task}/members/{member}/respond', [TaskMemberController::class, 'respond'])->name('tasks.members.respond');
});

// SRS-007: panel admin (hanya admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
