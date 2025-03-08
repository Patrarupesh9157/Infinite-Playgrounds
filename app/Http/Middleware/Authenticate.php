<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is not authenticated, redirect them to the appropriate page
        if (!Auth::check()) {
            return $this->redirectTo($request);
        }

        // If the user is authenticated, continue with the request
        return $next($request);
    }

    /**
     * Redirect users based on their roles or the requested route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function redirectTo(Request $request): Response
    {
        if (!$request->expectsJson()) {
            
            // dd($request->expectsJson());
            // Check if the authenticated user is an admin and accessing admin routes
            if ($request->is('admin*')) {
                return redirect()->route('admin.login');
            }

            // Check if the authenticated user is a regular user and accessing user routes
            if ($request->is('user*')) {
                return redirect()->route('login');
            }

            // Default redirect for non-authenticated users
            return redirect()->route('login');
        }

        // Return a 401 Unauthorized response for API or JSON requests
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
