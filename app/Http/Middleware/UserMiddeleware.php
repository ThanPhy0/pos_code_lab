<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddeleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // This is don't allow to login when login with admin or super admin. you can go every route with user account only login
        if (Auth::user()) {
            if (Auth::user()->role == 'user') {
                return $next($request);
            } else {
                return back();
            }
        }
    }
}
