<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CapturePreviousUrl
{
    public function handle(Request $request, Closure $next)
    {
        // Only capture on GET requests to avoid overwriting on POST (e.g., login form submission)
        if (
            $request->method() === 'GET' &&
            !$request->is('login') &&
            !$request->is('register') &&
            !$request->is('logout')
        ) {
            session(['previous_url' => url()->full()]);
        }

        return $next($request);
    }
}
