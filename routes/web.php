<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\RideRequestController;

// Public Routes (No Auth/Role Required)
Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

// Dashboard Route (Auth Required)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // Redirect based on role
        $user = Auth::user();
        $role = $user->role ?? 'user';

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'driver' => redirect()->route('driver.dashboard'),
            default => redirect()->route('user.dashboard'),
        };
    })->name('dashboard');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('dashboard.admin');
        })->name('admin.dashboard');
        // 🔹 Admin User Management
        Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{id}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [UserManagementController::class, 'update'])->name('admin.users.update');
        Route::get('/admin/rides', function () {
            return view('admin.rides.index'); // Ensure this Blade file exists
        })->name('admin.rides.index');
    });

    //  Driver Routes
    Route::middleware('role:driver')->group(function () {
        Route::get('/driver/dashboard', function () {
            return view('dashboard.driver');
        })->name('driver.dashboard');
        Route::get('/driver/rides', [RideRequestController::class, 'index'])->name('driver.rides');
        Route::post('/ride/{id}/accept', [RideRequestController::class, 'accept'])->name('ride.accept');

        // New Route for Tracking Assigned Rides
        Route::get('/driver/assigned-rides', [RideRequestController::class, 'assignedRides'])->name('driver.assigned.rides');

        // New Route for Completing a Ride
        Route::post('/ride/{id}/complete', [RideRequestController::class, 'completeRide'])->name('ride.complete');
         // New Route for Driver Ride History (Completed Rides)
    Route::get('/driver/ride-history', [RideRequestController::class, 'driverRideHistory'])->name('driver.ride.history');
    });


    // User Routes
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', function () {
            return view('dashboard.user');
        })->name('user.dashboard');

        // ADD THIS: Route for user to request a ride
        Route::get('/user/request-ride', function () {
            return view('request_a_ride'); // Ensure this Blade file exists
        })->name('ride.request.view');

        // New Route for Tracking User Ride History
        Route::get('/user/ride-history', [RideRequestController::class, 'userRides'])->name('user.ride.history');
        //Ride cancel
        Route::post('/ride/{id}/cancel', [RideRequestController::class, 'cancel'])->name('ride.cancel');

    });
});

// Profile Routes + Logout (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout Route
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


// Ride Requests
Route::middleware(['auth'])->group(function () {
    Route::post('/ride/request', [RideRequestController::class, 'store'])->name('ride.request');

    Route::middleware('role:driver')->group(function () {
        Route::get('/driver/rides', [RideRequestController::class, 'index'])->name('driver.rides');
        Route::post('/ride/{id}/accept', [RideRequestController::class, 'accept'])->name('ride.accept');
    });

});
