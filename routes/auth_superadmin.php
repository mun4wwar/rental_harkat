<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;


// ✅ Route setelah login
Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'role:SuperAdmin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('admins', AdminController::class);
});
