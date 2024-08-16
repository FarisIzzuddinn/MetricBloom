<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson() && ! $request->user()) {
            return route('login');
        }

        if ($request->user()->role === 'Admin') {
            return route('admin.dashboard');
        } elseif ($request->user()->role === 'superAdmin') {
            return view('superAdmin.permission.index');
        } else {
            return route('user.dashboard');
        }
    }
}

