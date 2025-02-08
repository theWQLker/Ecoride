<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// 🔓 Public Routes (No Middleware Restrictions)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    // Login Routes
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Registration Routes
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// 📌 Authenticated Routes (Only accessible after login)
Route::middleware('auth')->group(function () {
    Route::get('/redirect', function () {
        if (!Auth::check()) {
            return redirect('/login');
        }

        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'driver' => redirect()->route('driver.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => redirect('/login'),
        };
    });

    // 👑 Admin Routes
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('dashboard.admin');
        })->name('admin.dashboard');
    });

    // 🚗 Driver Routes
    Route::middleware(['auth', 'role:driver'])->group(function () {
        Route::get('/driver/dashboard', function () {
            return view('dashboard.driver');
        })->name('driver.dashboard');
    });

    // 👤 User Routes
    Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/user/dashboard', function () {
            return view('dashboard.user');
        })->name('user.dashboard');
    });
});

// 🔑 Authentication Routes from Laravel
require __DIR__.'/auth.php';
