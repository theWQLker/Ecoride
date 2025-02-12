@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-xl">
    <!-- Photo de profil -->
    <div class="text-center">
        <img src="{{ auth()->user()->profile_picture ?? asset('images/default-avatar.png') }}" 
             alt="Profile Picture" 
             class="w-24 h-24 rounded-full mx-auto">
        <h2 class="text-xl font-semibold mt-2">{{ auth()->user()->name }}</h2>
        <p class="text-gray-500">{{ auth()->user()->role }}</p>
    </div>

    <!-- Wallet et statistiques -->
    <div class="mt-6 flex justify-around bg-gray-100 p-4 rounded-lg">
        <div class="text-center">
            <h3 class="text-lg font-semibold">€{{ auth()->user()->wallet_balance }}</h3>
            <p class="text-gray-500">Wallet</p>
        </div>
        <div class="text-center">
            <h3 class="text-lg font-semibold">{{ auth()->user()->completed_rides }}</h3>
            <p class="text-gray-500">Completed Rides</p>
        </div>
        <div class="text-center">
            <h3 class="text-lg font-semibold">{{ auth()->user()->rating }}⭐</h3>
            <p class="text-gray-500">Rating</p>
        </div>
    </div>

    <!-- Préférences utilisateur -->
    <div class="mt-6">
        <h3 class="text-lg font-semibold">Preferences</h3>
        <form action="{{ route('profile.updatePreferences') }}" method="POST">
            @csrf
            <div class="mt-2">
                <label class="flex items-center">
                    <input type="checkbox" name="no_smoking" class="mr-2" {{ auth()->user()->no_smoking ? 'checked' : '' }}>
                    No Smoking
                </label>
            </div>
            <div class="mt-2">
                <label class="flex items-center">
                    <input type="checkbox" name="pets_allowed" class="mr-2" {{ auth()->user()->pets_allowed ? 'checked' : '' }}>
                    Pets Allowed
                </label>
            </div>
            <div class="mt-2">
                <label class="flex items-center">
                    <input type="checkbox" name="music_preference" class="mr-2" {{ auth()->user()->music_preference ? 'checked' : '' }}>
                    Enjoys Music
                </label>
            </div>
            <button type="submit" class="mt-4 bg-green-500 text-white py-2 px-4 rounded">Save Preferences</button>
        </form>
    </div>

    <!-- Historique des trajets -->
    <div class="mt-6">
        <h3 class="text-lg font-semibold">Ride History</h3>
        <ul class="mt-2">
            {{ dd(auth()->user()->rides) }}
            @foreach(auth()->user()->rides as $ride)
                <li class="bg-gray-100 p-3 mt-2 rounded-lg">
                    <strong>{{ $ride->origin }} → {{ $ride->destination }}</strong> 
                    <span class="text-gray-500 block">{{ $ride->date }} - {{ $ride->status }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
