<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/* ------------------------------------------------------------------ */
/*  Guest-only authentication routes */
/* ------------------------------------------------------------------ */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/* Logout (authenticated only) */
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/* ------------------------------------------------------------------ */
/*  Authenticated task routes */
/* ------------------------------------------------------------------ */
Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('tasks.index'));
    Route::resource('tasks', TaskController::class);
    Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
});
