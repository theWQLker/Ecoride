

{
    /**
     * Display the user's profile page. // Affiche la page du profil utilisateur
     */
    public function index(): View
    {
        $user = User::with('rides')->findOrFail(Auth::id()); // Charge l'historique des trajets
        return view('profile.index', compact('user'));
    }

    /**
     * Update the user's profile information. // Met à jour les informations du profil utilisateur
     */
    public function update(Request $request): RedirectResponse
    {
        $user = User::findOrFail(Auth::id());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);
        
        if ($user->email !== $validatedData['email']) {
            $validatedData['email_verified_at'] = null;
        }
        
        $user->update($validatedData);
        return Redirect::route('profile.index')->with('status', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account. // Supprime le compte utilisateur
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'current_password']]);
        $user = User::findOrFail(Auth::id());
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }

    /**
     * Show the driver profile page // Affiche la page du profil conducteur avec infos véhicule
     */
    public function driverProfile(): View
    {
        $user = User::with('vehicle', 'rides')->findOrFail(Auth::id());
        return view('profile.driver', compact('user'));
    }

    /**
     * Update vehicle information for driver // Met à jour les informations du véhicule du conducteur
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
     * Update driver and user preferences // Met à jour les préférences de l'utilisateur
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'no_smoking' => 'nullable|boolean',
            'pets_allowed' => 'nullable|boolean',
            'accept_long_trips' => 'nullable|boolean',
            'car_type_preference' => 'nullable|string|max:255',
            'enjoys_music' => 'nullable|boolean',
            'prefers_female_driver' => 'nullable|boolean',
            'custom_preference' => 'nullable|string|max:255',
        ]);

        $user->update([
            'no_smoking' => $request->has('no_smoking'),
            'pets_allowed' => $request->has('pets_allowed'),
            'accept_long_trips' => $request->has('accept_long_trips'),
            'car_type_preference' => $request->input('car_type_preference'),
            'enjoys_music' => $request->has('enjoys_music'),
            'prefers_female_driver' => $request->has('prefers_female_driver'),
        ]);

        DB::connection('mongodb')->collection('user_preferences')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'no_smoking' => $request->has('no_smoking'),
                'pets_allowed' => $request->has('pets_allowed'),
                'accept_long_trips' => $request->has('accept_long_trips'),
                'car_type_preference' => $request->input('car_type_preference'),
                'enjoys_music' => $request->has('enjoys_music'),
                'prefers_female_driver' => $request->has('prefers_female_driver'),
                'custom_preference' => $request->input('custom_preference'),
            ]
        );

        return redirect()->route('profile.index')->with('success', 'Preferences updated successfully!');
    }
}
