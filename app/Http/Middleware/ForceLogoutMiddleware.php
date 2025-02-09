<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceLogoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Force logout any authenticated user, invalidate the session, regenerate the CSRF token,
     * and remove the remember-me cookie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Log out the user (if any)
        Auth::logout();
        
        // Invalidate the session and regenerate the CSRF token.
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Continue with the request.
        $response = $next($request);
        
        // Remove the remember-me cookie.
        $rememberCookieName = Auth::guard()->getRecallerName();
        return $response->withCookie(cookie()->forget($rememberCookieName));
    }
}
