<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role; // Assuming 'role' is the column storing role info
            
            if ($userRole == 1 && !$request->routeIs('user.*')) {
                // Redirect regular user to user dashboard if they are not already there
                return redirect()->route('user.index');
            } elseif ($userRole == 2 && !$request->routeIs('admin.*')) {
                // Allow admins to access any admin route
                return $next($request);
            }
        } else {
            // If not authenticated, redirect to login
            return redirect()->route('login');
        }
    
        // Allow the request to proceed if it passes all checks
        return $next($request);
    } 

}
