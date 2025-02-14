

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\RideRequest;
use Illuminate\Support\Facades\Log;


class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index(): View
    {
        // $user = User::with(['rides' => function ($query) {
        //     $query->where('status', 'completed')->orderBy('created_at', 'desc');
        // }])->findOrFail(Auth::id());

        // return view('profile.index', compact('user'));

        $user = User::with([
            'rides' => function ($query) {
                $query->orderBy('created_at', 'desc'); // Removed status filter for debugging
            },
            'driverRides' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'vehicle' // Ensure this is correctly fetched
        ])->findOrFail(Auth::id());


        $user = User::with([
            'rides' => function ($query) {
                $query->orderBy('created_at', 'desc'); // Load all rides, not just completed
            },
            'driverRides' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'vehicle'
        ])->findOrFail(Auth::id());

        $preferences = DB::connection('mongodb')->table('user_preferences')->where('user_id', Auth::id())->first();

        return view('profile.index', compact('user', 'preferences'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = User::findOrFail(Auth::id());
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
        $user = User::with('vehicle')->findOrFail(Auth::id());
        // Retrieve preferences from MongoDB
        $preferences = DB::connection('mongodb')->table('user_preferences')->where('user_id', Auth::id())->first();

        Log::info('Loaded Preferences:', ['user_id' => Auth::id(), 'preferences' => $preferences]);
        return view('profile.index', compact('user', 'preferences'));
        // return view('profile.driver', compact('user'));
    }

    /**
     * Update vehicle information for driver.
     */
    public function updateVehicle(Request $request): RedirectResponse
    {
        $user = User::findOrFail(Auth::id());
        $request->validate([
            'model' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20',
            'fuel_type' => 'required|string|max:50',
        ]);

        Vehicle::updateOrCreate(
            ['driver_id' => $user->id],
            $request->only(['model', 'plate_number', 'fuel_type'])
        );

        return redirect()->route('profile.driver')->with('success', 'Vehicle updated successfully');
    }

    /**
     * Update user and driver preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {

        $user = User::findOrFail(Auth::id());
        $validated = $request->validate([
            'no_smoking' => 'nullable|boolean',
            'pets_allowed' => 'nullable|boolean',
            'accept_long_trips' => 'nullable|boolean',
            'car_type_preference' => 'nullable|string|max:255',
            'enjoys_music' => 'nullable|boolean',
            'prefers_female_driver' => 'nullable|boolean',
            'custom_preference' => 'nullable|string|max:255',
        ]);
        Log::info('User Preferences Updated:', ['user_id' => Auth::id(), 'data' => $validated]);


    // Fetch existing preferences
    $existingPreferences = DB::connection('mongodb')->table('user_preferences')->where('user_id', $user->id)->first();

    // Merge new preferences with existing ones
    $newPreferences = array_merge(
        (array) ($existingPreferences->preferences ?? []),
        $validated
    );

        $user->update($validated);
        DB::connection('mongodb')->table('user_preferences')->updateOrInsert(
            ['user_id' => Auth::id()], // Use Auth::id() explicitly
            $validated
        );
        return redirect()->route('profile.index')->with('success', 'Preferences updated successfully!');
    }
}
