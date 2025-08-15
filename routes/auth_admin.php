<?php

use App\Http\Controllers\Auth\AuthAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MobilController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\SupirController;
use App\Http\Controllers\Admin\TipeMobilController;
use App\Http\Controllers\Admin\TransaksiController;

// ✅ Route Login & Post Login dipisah di luar middleware auth
Route::prefix('admin')->name('admin.')->middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthAdminController::class, 'loginFormAdmin'])->name('login');
    Route::post('/login', [AuthAdminController::class, 'loginAdmin']);
});

// ✅ Route setelah login
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:2,admin'])->group(function () {
    Route::post('/logout', [AuthAdminController::class, 'logoutAdmin'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tipe-mobil', TipeMobilController::class);
    Route::resource('mobil', MobilController::class);
    Route::resource('supir', SupirController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('transaksi', TransaksiController::class);
});
