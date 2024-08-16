<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoleMiddleware
{
    // public function handle(Request $request, Closure $next)
    // {
    //     // Check if the user is authenticated and has the 'user' role
    //     if (Auth::check() && Auth::user()->hasRole('user')) {
    //         // User is authenticated and has the 'user' role, allow the request to proceed
    //         return $next($request);
    //     }

    //     // User is not authenticated or does not have the 'user' role
    //     // You can customize the response here based on your application's needs
    //     // For example, redirect to a specific route or return an error message
    //     return redirect()->route('login')->with('error', 'You are not authorized to access this page.');
    // }
}
