<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDashboardAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has admin role or dashboard access permission
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasPermissionTo('access-dashboard')) {
            // Redirect to home page with a message
            return redirect()->route('home');
        }

        return $next($request);
    }
}
