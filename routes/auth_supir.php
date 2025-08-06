<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthSupirController;
use App\Http\Controllers\Supir\SupirDashboardController;

Route::prefix('supir')->name('supir.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('supir.login');
    })->middleware('guest:supir');
    // Auth
    Route::middleware('guest:supir')->group(function () {
        Route::get('/login', [AuthSupirController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthSupirController::class, 'login']);
    });

    Route::middleware('auth:supir')->group(function () {
        // Dashboard supir
        Route::get('/dashboard', [SupirDashboardController::class, 'index'])->name('dashboard');
        
        Route::post('/logout', [AuthSupirController::class, 'logout'])->name('logout');
        // Tambah route supir lainnya di sini
    });
});
