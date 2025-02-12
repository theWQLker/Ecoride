<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPreference;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserPreferenceController extends Controller
{
    // Store or update user preferences
    // Enregistrer ou mettre à jour les préférences utilisateur
    public function storeUserPreference(Request $request)
    {
        $request->validate([
            'preferences' => 'required|array'
        ]);

        // Retrieve authenticated user ID
        // Récupérer l'ID de l'utilisateur authentifié
        $userId = Auth::id();

        // Save or update preferences in MongoDB
        // Enregistrer ou mettre à jour les préférences dans MongoDB
        $preference = UserPreference::updateOrCreate(
            ['user_id' => $userId],
            ['preferences' => $request->preferences]
        );

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

    $user->update($validated);

    // Ensure MongoDB connection is properly initialized
    DB::connection('mongodb')->collection('user_preferences')->updateOrInsert(
        ['user_id' => $user->id],
        array_merge(['user_id' => $user->id], $validated)
    );

    return redirect()->route('profile.index')->with('success', 'Preferences updated successfully!');
}

    //     return response()->json(['message' => 'Preferences saved successfully!', 'data' => $preference]); // Préférences enregistrées avec succès !
    // }

    // Retrieve user preferences
    // Récupérer les préférences utilisateur

    
    public function getUserPreference()
    {
        $userId = Auth::id();
        $preference = UserPreference::where('user_id', $userId)->first();

        if (!$preference) {
            return response()->json(['message' => 'No preferences found'], 404); // Aucune préférence trouvée
        }

        return view('user.preferences', compact('preference'));
    }
}
