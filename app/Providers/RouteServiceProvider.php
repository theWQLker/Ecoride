<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is where users are redirected after login or registration.
     */
    public const HOME = '/redirect'; // ✅ Redirect after login

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        //
    }
}
