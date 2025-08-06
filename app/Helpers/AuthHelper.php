<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthHelper
{
    public static function logoutCurrentGuard(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login'); // ← PENTING
        }

        if (Auth::guard('supir')->check()) {
            Auth::guard('supir')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('supir.login');
        }

        // default: web/customer
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
