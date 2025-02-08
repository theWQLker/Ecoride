<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->routeIs('login') || $request->routeIs('register')) {
            return $next($request);
        }

        if (!Auth::check()) {
            return redirect('/login');
        }

        if (!$role) {
            return abort(403, 'Role parameter is missing');
        }

        if (Auth::user()->role !== $role) {
            return redirect('/login'); // Redirect unauthorized users
        }

        return $next($request);
    }
}
