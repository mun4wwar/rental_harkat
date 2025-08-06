<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing-page');

Route::get('/cek-login', function () {
    return [
        'active_guard_from_session' => session('guard'),
        'active_guard' => Auth::getDefaultDriver(),
        'admin' => Auth::guard('admin')->check(),
        'web' => Auth::guard('web')->check(),
        'supir' => Auth::guard('supir')->check(),
    ];
});

Route::get('/cek-auth', function () {
    return [
        'admin' => Auth::guard('admin')->check(),
        'web' => Auth::guard('web')->check(),
        'supir' => Auth::guard('supir')->check(),
    ];
});

Route::get('/debug-auth', function () {
    return [
        'web' => Auth::guard('web')->check(),
        'admin' => Auth::guard('admin')->check(),
        'supir' => Auth::guard('supir')->check(),
        'user' => Auth::user(),
    ];
});

Route::get('/debug-session', function () {
    return [
        'admin_logged_in' => Auth::guard('admin')->check(),
        'web_logged_in' => Auth::guard('web')->check(),
        'supir_logged_in' => Auth::guard('supir')->check(),
        'current_user' => Auth::user(),
        'guard_admin_user' => Auth::guard('admin')->user(),
    ];
});

require __DIR__ . '/auth.php';
require __DIR__ . '/auth_admin.php';
require __DIR__ . '/auth_supir.php';
