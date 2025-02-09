<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/routes/web.php',          // ✅ Correct Web Route Path
        commands: __DIR__.'/routes/console.php', // ✅ Correct Console Route Path
        health: '/up'                            // ✅ Keeps health check
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Ensure the Role Middleware is registered
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // ⚠️ Keep empty for now
    })
    ->create();
