<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is an user
        if (Auth::check() && Auth::user()->role === 'user') {
            // User is an user, allow the request to proceed
            return $next($request);
        }

        // User is not authenticated or is not an user, redirect or return error
        return redirect()->route('admin.index')->with('error', 'You are not authorized to access this page.');
    }
}
