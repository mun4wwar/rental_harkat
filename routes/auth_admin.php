<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MobilController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\SupirController;
use App\Http\Controllers\Admin\TipeMobilController;


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tipe-mobil', TipeMobilController::class);
    Route::resource('mobil', MobilController::class);
    Route::resource('supir', SupirController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('booking', BookingController::class);

    Route::post('/booking/{bookingDtl}/send', [BookingController::class, 'assignJobSupir'])
        ->name('assignJob');
    // Tambah route supir lainnya di sini

});
