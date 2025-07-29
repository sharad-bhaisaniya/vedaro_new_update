<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CapturePreviousUrl
{
    public function handle(Request $request, Closure $next)
    {
        if (
            $request->method() === 'GET' &&
            !auth()->check() &&
            !$request->is('login') &&
            !$request->is('logout') &&
            !$request->ajax()
        ) {
             session(['url.intended' => url()->full()]);
            // Log::info('URL Captured: ' . url()->full()); // Debug
        }

        return $next($request);
    }
}
