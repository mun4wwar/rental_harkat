<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MobilController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\SupirController;
use App\Http\Controllers\Admin\TransaksiController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthenticatedSessionController::class, 'showAdminLoginForm'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');

        // Dashboard dan fitur admin
        Route::middleware('role:1')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('mobil', MobilController::class);
            Route::resource('supir', SupirController::class);
            Route::resource('pelanggan', PelangganController::class);
            Route::resource('transaksi', TransaksiController::class);
        });
    });
});
