<?php
// app/Http/Middleware/CapturePreviousUrl.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CapturePreviousUrl
{
    public function handle(Request $request, Closure $next)
    {
        if (
            $request->method() === 'GET' &&
            !auth()->check() &&
            !$request->is('login') &&    // avoid login page
            !$request->is('logout') &&   // avoid logout
            !$request->is('register') && // optional
            !$request->ajax()
        ) {
            session(['url.intended' => url()->full()]);
        }

        return $next($request);
    }
}