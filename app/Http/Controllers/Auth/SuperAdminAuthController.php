<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminAuthController extends Controller
{
    public function loginFormSuperAdmin()
    {
        return view('auth.superadmin-login');
    }

    public function loginSuperAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth('superadmin')->attempt($credentials)) {
            if (auth('superadmin')->user()->role == 1) {
                $request->session()->regenerate();
                return redirect()->route('superadmin.dashboard'); // <- ini dia kuncinya
            }

            auth('admin')->logout();
        }

        return back()->withErrors(['email' => 'Login gagal']);
    }

    public function logoutSuperAdmin(Request $request)
    {
        auth('superadmin')->logout();

        // Bersihin semua session
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing-page');
    }
}
