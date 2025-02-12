<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Définition du comportement des routes.
     * Define route behaviors.
     */
    public function boot(): void
    {
        // Définir le limiteur de taux pour les requêtes API
        // Set rate limiter for API requests

        // Enregistrement des routes Web et API
        // Register Web and API routes
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        // Enregistrement du middleware de rôle
        // Register role middleware
        Route::aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
    }
}
