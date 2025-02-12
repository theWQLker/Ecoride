<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UserPreference extends Model
{
    protected $connection = 'mongodb'; // Connexion à MongoDB
    protected $collection = 'user_preferences'; // Collection MongoDB
    protected $fillable = ['user_id', 'preferences']; // Champs remplissables
}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPreference;

class UserPreferenceController extends Controller
{
    // Enregistrer ou mettre à jour les préférences utilisateur
    public function storeUserPreference(Request $request)
    {
        $request->validate([
            'preferences' => 'required|array'
        ]);
        
        $userId = Auth::id();
        $preference = UserPreference::updateOrCreate(
            ['user_id' => $userId],
            ['preferences' => $request->preferences]
        );
        
        return response()->json(['message' => 'Preferences saved successfully!', 'data' => $preference]);
    }

    // Récupérer les préférences utilisateur
    public function getUserPreference()
    {
        $userId = Auth::id();
        $preference = UserPreference::where('user_id', $userId)->first();

        if (!$preference) {
            return response()->json(['message' => 'No preferences found'], 404);
        }

        return response()->json(['data' => $preference]);
    }
}
