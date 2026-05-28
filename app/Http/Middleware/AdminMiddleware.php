<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('admin.login');
        }

        if (!auth('admin')->user()->is_active) {
            auth('admin')->logout();
            return redirect()->route('admin.login')->withErrors(['email' => 'Account is disabled']);
        }

        return $next($request);
    }
}
