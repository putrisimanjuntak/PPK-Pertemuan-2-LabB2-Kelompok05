<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/api/tasks', [TaskController::class, 'getTasks']);
Route::post('/api/tasks', [TaskController::class, 'store']);
Route::patch('/api/tasks/{task}/toggle', [TaskController::class, 'toggle']);
Route::delete('/api/tasks/{task}', [TaskController::class, 'destroy']);

Route::get('/api/projects', [ProjectController::class, 'index']);
Route::post('/api/projects', [ProjectController::class, 'store']);