<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role, $guard = 'web')
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::guard($guard)->user()->role == $role) {
                return $next($request);
            }
            // Kalau login tapi role nggak sesuai → logout dulu biar gak looping
            Auth::guard($guard)->logout();
            return redirect()->route($guard === 'web' ? 'login' : "{$guard}.login")
                ->withErrors(['email' => 'Akses ditolak. Role tidak sesuai.']);
        }

        // Redirect sesuai guard
        switch ($guard) {
            case 'admin':
                return redirect()->route('admin.login');
            case 'web':
                return redirect()->route('login');
            case 'supir':
                return redirect()->route('supir.login');
            default:
                return redirect()->route("{$guard}.login")->withErrors([
                    'email' => 'Akses ditolak. Role tidak sesuai.',
                ]);
        }
    }
}
