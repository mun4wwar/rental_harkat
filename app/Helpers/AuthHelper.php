<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AuthHelper
{
    public static function logoutCurrentGuard(Request $request): RedirectResponse
    {
        if (auth('superadmin')->check()) {
            auth('superadmin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('superadmin.login'); // ← PENTING
        }
        if (auth('admin')->check()) {
            auth('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login'); // ← PENTING
        }

        if (auth('supir')->check()) {
            auth('supir')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('supir.login');
        }

        // default: web/customer
        auth('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
