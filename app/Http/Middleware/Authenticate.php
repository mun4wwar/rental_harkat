<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('superadmin*')) return '/login/superadmin';
            if ($request->is('admin*')) return '/login/admin';
            if ($request->is('supir*')) return '/supir/login';
            // if ($request->is('home') || $request->is('customer*')) return '/login/customer';
            return '/login'; // fallback
        }
    }
}
