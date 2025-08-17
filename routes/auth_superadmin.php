<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;

// ✅ Route Login & Post Login dipisah di luar middleware auth
Route::prefix('superadmin')->name('superadmin.')->middleware('guest:superadmin')->group(function () {
    Route::get('/login', [SuperAdminAuthController::class, 'loginFormSuperAdmin'])->name('login');
    Route::post('/login', [SuperAdminAuthController::class, 'loginSuperAdmin']);
});

// ✅ Route setelah login
Route::prefix('superadmin')->name('superadmin.')->middleware(['auth:superadmin', 'role:1,superadmin'])->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('dashboard');
    Route::post('/logout', [SuperAdminAuthController::class, 'logoutSuperAdmin'])->name('logout');
});
