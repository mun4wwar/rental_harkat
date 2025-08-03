<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function showCustomerLoginForm()
    {
        return view('auth.cust-login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $from = $request->input('login_from');

            if ($from === 'admin' && $user->role != 1) {
                Auth::logout();
                return redirect()->route('admin.login')->withErrors(['email' => 'Kredensial bukan admin.']);
            }

            if ($from === 'customer' && $user->role != 2) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Kredensial bukan customer.']);
            }

            // Redirect sesuai role
            return $user->role == 1
                ? redirect()->route('admin.dashboard')
                : redirect()->route('customer.dashboard');
        }


        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
