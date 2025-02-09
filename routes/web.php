<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

// 🏠 Public Routes (No Auth/Role Required)
Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// 📌 Dashboard Route (Auth Required)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // Redirect based on role
        $user = Auth::user();
        $role = $user->role ?? 'user';

        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'driver' => redirect()->route('driver.dashboard'),
            default => redirect()->route('user.dashboard'),
        };
    })->name('dashboard');

    // 👑 Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('dashboard.admin');
        })->name('admin.dashboard');
    });

    // 🚗 Driver Routes
    Route::middleware('role:driver')->group(function () {
        Route::get('/driver/dashboard', function () {
            return view('dashboard.driver');
        })->name('driver.dashboard');
    });

    // 👤 User Routes
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', function () {
            return view('dashboard.user');
        })->name('user.dashboard');
    });
});

// 🔑 Profile Routes + Logout (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🚪 Logout Route
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Load authentication routes from auth.php
