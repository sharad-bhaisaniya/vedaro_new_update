<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CapturePreviousUrl
{
    public function handle(Request $request, Closure $next)
    {
        // Store the previous URL in the session (only if it's not the login or register page)
        if (!in_array(url()->current(), [route('login'), route('register')])) {
            session(['previous_previous_url' => session('previous_url', url()->previous())]);
            session(['previous_url' => url()->previous()]);
        }

        return $next($request);
    }
}
