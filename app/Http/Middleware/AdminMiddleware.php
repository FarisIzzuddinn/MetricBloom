<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            /** @var App\Models\User */
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return $next($request);
            }
            // Redirect to a custom unauthorized page
            return redirect()->route('unauthorized');
        }
    
        abort(401); // Unauthorized: user not logged in
    }
}
