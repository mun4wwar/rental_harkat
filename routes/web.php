<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MobilController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SupirController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin
Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('mobil', MobilController::class);
    Route::resource('supir', SupirController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('transaksi', TransaksiController::class);
    // dst...
});
// Route::resource('/mobil', MobilController::class);

require __DIR__ . '/auth.php';
