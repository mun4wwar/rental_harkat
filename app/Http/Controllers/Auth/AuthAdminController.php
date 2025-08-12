<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdminController extends Controller
{
    public function loginFormAdmin()
    {
        return view('auth.admin-login');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            if (Auth::guard('admin')->user()->role == 2) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard'); // <- ini dia kuncinya
            }

            Auth::guard('admin')->logout();
        }

        return back()->withErrors(['email' => 'Login gagal']);
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();

        // Bersihin semua session
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
