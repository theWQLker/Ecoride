<?php

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


     public function show($id)
     {
         $user = User::find($id);
     
         // Ensure preferences exist before accessing them
         $preferences = $user->preferences ?? [];
     
         return view('profile.show', compact('user', 'preferences'));
     }
     
     public function index()
     {
         $user = Auth::user();
 
         // Récupérer les préférences de l'utilisateur
         $preferences = DB::connection('mongodb')->table('user_preferences')->where('user_id', $user->id)->first();
 
         // Convertir stdClass en array pour éviter les erreurs
         $preferences = $preferences ? json_decode(json_encode($preferences), true) : [];
 
         return view('profile.index', compact('user', 'preferences'));
     }
    // public function index(): View
    // {
    //     $user = User::with([
    //         'rides' => function ($query) {
    //             $query->orderBy('created_at', 'desc');
    //         },
    //         'driverRides' => function ($query) {
    //             $query->orderBy('created_at', 'desc');
    //         },
    //         'vehicle'
    //     ])->findOrFail(Auth::id());

    //     $preferences = DB::connection('mongodb')->table('user_preferences')->where('user_id', Auth::id())->first();

    //     // Convertir en tableau et définir des valeurs par défaut si `$preferences` est null
    //     $preferences = $preferences ? json_decode(json_encode($preferences), true) : [];

    //     // Valeurs par défaut pour éviter les erreurs de clés manquantes
    //     $preferences = array_merge([
    //         'smoking_allowed' => false,
    //         'animals_allowed' => false,
    //         'additional_preferences' => []
    //     ], $preferences);
    //     // Passer à la vue
    //     return view('profile.index', compact('user', 'preferences'));

    //     // $preferences = DB::connection('mongodb')->collection('user_preferences')
    //     //     ->where('user_id', $user->id)
    //     //     ->first();

    //     // Si aucune préférence trouvée, initialise un tableau par défaut
    //     if (!$preferences) {
    //         $preferences = [
    //             'smoking_allowed' => false,
    //             'animals_allowed' => false,
    //             'additional_preferences' => []
    //         ];
    //     } else {
    //         $preferences = json_decode(json_encode($preferences), true); // Convertit stdClass en tableau
    //     }

    //     // Passer à la vue
    //     return view('profile.index', compact('user', 'preferences'));
    // }

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
        $preferences = DB::connection('mongodb')->table('user_preferences')->where('user_id', Auth::id())->first();

        Log::info('Loaded Preferences:', ['user_id' => Auth::id(), 'preferences' => $preferences]);
        return view('profile.index', compact('user', 'preferences'));
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

     public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        // Récupérer les préférences actuelles
        $existingPreferences = DB::table('user_preferences')->where('user_id', $user->id)->first();
        $existingPreferences = $existingPreferences ? json_decode(json_encode($existingPreferences), true) : [];

        // Nouvelles préférences venant du formulaire
        $newPreferences = [
            'no_smoking' => $request->has('no_smoking'),
            'pets_allowed' => $request->has('pets_allowed'),
            'enjoys_music' => $request->has('enjoys_music'),
            'prefers_female_driver' => $request->has('prefers_female_driver'),
            'accept_long_trips' => $request->has('accept_long_trips'),
            'car_type_preference' => $request->has('car_type_preference'),
        ];

        // Gestion des préférences personnalisées
        if ($request->filled('custom_preference')) {
            $customPref = trim($request->input('custom_preference'));

            // Vérifier s'il existe déjà pour éviter les doublons
            if (!isset($existingPreferences['custom_preferences']) || !in_array($customPref, $existingPreferences['custom_preferences'])) {
                $existingPreferences['custom_preferences'][] = $customPref;
            }
        }

        // Fusionner les nouvelles préférences avec les anciennes
        $updatedPreferences = array_merge($existingPreferences, $newPreferences);

        // Mettre à jour ou insérer les préférences sans écraser l'existant
        DB::table('user_preferences')->updateOrInsert(
            ['user_id' => $user->id], // Critère de recherche
            ['preferences' => json_encode($updatedPreferences), 'user_id' => $user->id]
        );

        return redirect()->back()->with('success', 'Preferences updated successfully!');
    }
}
//     public function updatePreferences(Request $request): RedirectResponse
//     {
//         $user = User::findOrFail(Auth::id());
//         $validated = $request->validate([
//             'no_smoking' => 'nullable|boolean',
//             'pets_allowed' => 'nullable|boolean',
//             'accept_long_trips' => 'nullable|boolean',
//             'car_type_preference' => 'nullable|string|max:255',
//             'enjoys_music' => 'nullable|boolean',
//             'prefers_female_driver' => 'nullable|boolean',
//             'custom_preference' => 'nullable|string|max:255',
//         ]);
//         Log::info('User Preferences Updated:', ['user_id' => Auth::id(), 'data' => $validated]);

//         DB::connection('mongodb')->table('user_preferences')->updateOrInsert(
//             ['user_id' => Auth::id()],
//             $validated
//         );
//         return redirect()->route('profile.index')->with('success', 'Preferences updated successfully!');
//     }
// }
