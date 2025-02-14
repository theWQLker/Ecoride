
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Vehicle;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index(): View
    {
        $user = Auth::user()->load(['rides' => fn ($q) => $q->latest(), 'driverRides' => fn ($q) => $q->latest(), 'vehicle']);
        $preferences = $user->getPreferences(); // Moved to User model

        return view('profile.index', compact('user', 'preferences'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($user->email !== $validatedData['email']) {
            $validatedData['email_verified_at'] = null;
        }

        $user->update($validatedData);
        return Redirect::route('profile.index')->with('status', 'Profile updated successfully!');
    }

    /**
     * Show the driver profile page.
     */
    public function driverProfile(): View
    {
        $user = Auth::user()->load('vehicle');
        $preferences = $user->getPreferences(); // Moved to User model

        Log::info('Loaded Preferences:', ['user_id' => $user->id, 'preferences' => $preferences]);

        return view('profile.driver', compact('user', 'preferences'));
    }

    /**
     * Update vehicle information for the driver.
     */
    public function updateVehicle(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $request->validate([
            'model' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20',
            'fuel_type' => 'required|string|max:50',
        ]);

        // Using Eloquent relationship for a cleaner approach
        $user->vehicle()->updateOrCreate(['driver_id' => $user->id], $request->only(['model', 'plate_number', 'fuel_type']));

        return redirect()->route('profile.index')->with('success', 'Vehicle updated successfully!');
    }

    /**
     * Update user and driver preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $validated = $request->validate([
            'no_smoking' => 'nullable|boolean',
            'pets_allowed' => 'nullable|boolean',
            'accept_long_trips' => 'nullable|boolean',
            'car_type_preference' => 'nullable|string|max:255',
            'enjoys_music' => 'nullable|boolean',
            'prefers_female_driver' => 'nullable|boolean',
            'custom_preference' => 'nullable|string|max:255',
        ]);

        Log::info('User Preferences Updated:', ['user_id' => $user->id, 'data' => $validated]);

        // Update MySQL user preferences
        $user->update($validated);

        // Update MongoDB preferences
        $user->updatePreferences($validated);

        return redirect()->route('profile.index')->with('success', 'Preferences updated successfully!');
    }
}
