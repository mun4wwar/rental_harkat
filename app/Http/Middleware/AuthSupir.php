<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class AuthSupir
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('supir')->check()) {
            return redirect()->route('supir.login');
        }

        return $next($request);
    }
}
