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
    public function handle(Request $request, Closure $next)
    {
        // Route prefix checker
        $uri = $request->path(); // e.g. admin/dashboard
        $isAdminRoute = str_starts_with($uri, 'admin');
        $isSupirRoute = str_starts_with($uri, 'supir');
        $isCustomerRoute = str_starts_with($uri, 'customer');

        // Admin check
        if ($isAdminRoute) {
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('admin.login');
            }
        }

        // Supir check
        if ($isSupirRoute) {
            if (!Auth::guard('supir')->check()) {
                return redirect()->route('supir.login');
            }
        }

        // Customer check (assume pakai 'web' guard)
        if ($isCustomerRoute) {
            if (!Auth::guard('web')->check()) {
                return redirect()->route('login'); // Breeze default
            }
        }

        return $next($request);
    }
}
