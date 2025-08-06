<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Supir;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthSupirController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.supir-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('supir')->attempt($credentials)) {
            $request->session()->regenerate();
            session(['guard' => 'supir']); // ← HARUS DI SINI
            return redirect()->route('supir.dashboard');
        }


        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('supir')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('supir.login');
    }
}
