

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\RideRequestController;
use App\Models\RideRequest;

// Public Routes (No Auth Required) // Routes publiques (aucune authentification requise)
Route::get('/', function () {
    return view('welcome');
});


require __DIR__ . '/auth.php';
Route::get('/profile/index', [ProfileController::class, 'index']);
// Protected Routes (Auth Required) // Routes protégées (authentification requise)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return match ($user->role ?? 'user') {
            'admin' => redirect()->route('admin.dashboard'),
            'driver' => redirect()->route('driver.dashboard'),
            default => redirect()->route('user.dashboard'),
        };
    })->name('dashboard');

    // Admin Routes // Routes administrateur
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('dashboard.admin');
        })->name('admin.dashboard');

        // Gestion des utilisateurs // User Management
        Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{id}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [UserManagementController::class, 'update'])->name('admin.users.update');
        
        // Gestion des trajets // Ride Management
        Route::get('/admin/rides', function () {
            $rides = RideRequest::with('user', 'driver')->get();
            return view('admin.rides.index', compact('rides'));
        })->name('admin.rides.index');
    });

    // Driver Routes // Routes conducteur
    Route::middleware('role:driver')->group(function () {
        Route::get('/driver/dashboard', function () {
            return view('dashboard.driver');
        })->name('driver.dashboard');

        // Gestion des trajets pour les conducteurs // Ride management for drivers
        Route::get('/driver/rides_requested', [RideRequestController::class, 'index'])->name('driver.rides_requested');
        Route::get('/driver/rides', [RideRequestController::class, 'index'])->name('driver.rides');
        Route::post('/ride/{id}/accept', [RideRequestController::class, 'accept'])->name('ride.accept');
        Route::get('/driver/assigned-rides', [RideRequestController::class, 'assignedRides'])->name('driver.assigned.rides');
        Route::post('/ride/{id}/complete', [RideRequestController::class, 'completeRide'])->name('ride.complete');
        Route::get('/driver/ride-history', [RideRequestController::class, 'driverRideHistory'])->name('driver.ride.history');

        Route::patch('/profile/driver/vehicle', [ProfileController::class, 'updateVehicle'])->name('profile.driver.vehicle.update');
        Route::post('/profile/driver/preferences', [ProfileController::class, 'updateDriverPreferences'])->name('profile.driver.preferences.update');
    });

    });

    // User Routes // Routes utilisateur
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', function () {
            return view('dashboard.user');
        })->name('user.dashboard');

        Route::get('/user/request-ride', function () {
            return view('request_a_ride');
        })->name('ride.request.view');

        Route::get('/user/ride-history', [RideRequestController::class, 'userRides'])->name('user.ride.history');
        Route::post('/ride/{id}/cancel', [RideRequestController::class, 'cancel'])->name('ride.cancel');
    });


// Profile Routes // Routes du profil
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.updatePreferences');

    // Logout Route // Déconnexion
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Ride Requests Routes // Routes pour les demandes de trajets
Route::middleware(['auth'])->group(function () {
    Route::post('/ride/request', [RideRequestController::class, 'store'])->name('ride.request');

    Route::post('/ride/{id}/accept', [RideRequestController::class, 'accept'])->name('ride.accept');
});
