<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show login form.
     */
    // Tampilkan login form per role
    public function showLoginForm($role)
    {
        $role = ucfirst(strtolower($role));

        return match ($role) {
            'Customer'   => view('auth.cust-login'),
            'Supir'      => view('auth.supir-login'),
            'Admin'      => view('auth.admin-login'),
            'Superadmin' => view('auth.superadmin-login'),
            default      => abort(404),
        };
    }

    // Login universal
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
            'role'     => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $role = ucfirst(strtolower($request->input('role'))); // Customer / Supir / Admin

        if (!Auth::attempt($credentials, $request->filled('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
        }

        $user = Auth::user();

        // cek role sesuai form login
        $valid = match ($role) {
            'Customer' => $user->isRole('Customer'),
            'Supir'    => $user->isRole('Supir'),
            'Admin'    => $user->isRole('Admin'),
            'SuperAdmin'    => $user->isRole('SuperAdmin'),
            default    => false,
        };

        if (!$valid) {
            Auth::logout();
            return back()->withErrors(['email' => "Bukan akun $role"]);
        }

        $request->session()->regenerate();

        // redirect otomatis sesuai role
        $redirects = [
            'SuperAdmin' => 'superadmin.dashboard',
            'Admin'      => 'admin.dashboard',
            'Supir'      => 'supir.dashboard',
            'Customer'   => 'home',
        ];

        return redirect()->route($redirects[$user->roleName] ?? 'landing-page');
    }

    // Logout universal
    public function logout(Request $request)
    {
        Auth::logout();

        // Bersihin semua session
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing-page');
    }
}
