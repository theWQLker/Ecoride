<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        // Define public routes that should bypass role checks.
        $publicRoutes = [
            'login', 
            'register', 
            'password.request', 
            'password.reset', 
            'password.email'
        ];

        // Retrieve the current route; if no route is found, allow the request.
        $route = $request->route();
        if ($route === null) {
            return $next($request);
        }

        // Get the route name.
        $routeName = $route->getName();
        // If the route is public, bypass role checking.
        if (in_array($routeName, $publicRoutes)) {
            return $next($request);
        }

        // Ensure the user is authenticated.
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check that the authenticated user has the required role.
        $user = Auth::user();
        if ($role && $user->role !== $role) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
