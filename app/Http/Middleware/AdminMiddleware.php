<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // When you have already login, don't allow to go back login form page.
        // All person superadmin, admin and user didn't go back to login and register page
        if (Auth::user()) { // when stay login
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'user') {
                // when call login and register in URL, kill request
                if ($request->route()->getName() == 'login' || $request->route()->getName()) {
                    return back();
                }
                // user can call all request login and register
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
