<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');
Route::post('/register', [AuthController::class, 'doRegister'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin');
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('showDashboard');
Route::get('/profile', [AuthController::class, 'showProfile'])->name('user.profile');
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('user.profile.update');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
