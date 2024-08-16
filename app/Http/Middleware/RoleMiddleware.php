<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors('You need to log in first');
        }

        /** @var User $user */
        $user = Auth::user(); 

        // Get the role from the configuration
        $role = config('roles.' . $role);

        // Check if the user has the required role
        if (!$role || !$user->hasRole($role)) {
            return redirect('/')->withErrors('You do not have permission to access this page');
        }

        return $next($request);
    }
}

