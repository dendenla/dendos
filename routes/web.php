<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TempatController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tempats');

Route::get('/tempats', [TempatController::class, 'index'])->name('tempats.index');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware(['guest', 'throttle:5,1']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('tempats', TempatController::class)->except(['index', 'show']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
