<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Access denied. Admin privileges required.');

        }

        return $next($request);
    }
}
