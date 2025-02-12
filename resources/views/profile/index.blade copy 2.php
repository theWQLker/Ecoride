@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
    <!-- Profile Header -->
    <div class="flex items-center space-x-4 border-b pb-4">
        <img src="/images/default-profile.png" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover border">
        <div>
            <h2 class="text-2xl font-semibold">{{ Auth::user()->name }}</h2>
            <p class="text-gray-600">{{ Auth::user()->email }}</p>
            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">{{ Auth::user()->role }}</span>
        </div>
    </div>

    <!-- Wallet & Ratings -->
    <div class="grid grid-cols-2 gap-4 mt-6">
        <div class="text-center p-4 bg-gray-50 rounded-lg shadow">
            <p class="text-lg font-semibold">€{{ Auth::user()->wallet ?? '0.00' }}</p>
            <p class="text-gray-600 text-sm">Wallet Balance</p>
        </div>
        <div class="text-center p-4 bg-gray-50 rounded-lg shadow">
            <p class="text-lg font-semibold">⭐ {{ Auth::user()->rating ?? 'N/A' }}</p>
            <p class="text-gray-600 text-sm">User Rating</p>
        </div>
    </div>

    <!-- Preferences -->
    <div class="mt-6 p-4 bg-gray-50 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Preferences</h3>
        <form method="POST" action="{{ route('profile.updatePreferences') }}">
            @csrf
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="no_smoking" {{ Auth::user()->no_smoking ? 'checked' : '' }} class="rounded border-gray-300">
                <span>No Smoking</span>
            </label>
            <label class="flex items-center space-x-2 mt-2">
                <input type="checkbox" name="pets_allowed" {{ Auth::user()->pets_allowed ? 'checked' : '' }} class="rounded border-gray-300">
                <span>Pets Allowed</span>
            </label>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg">Save Preferences</button>
        </form>
    </div>

    <!-- Ride History -->
    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-2">Completed Rides</h3>
        <ul class="space-y-3">
            @foreach ($user->rides as $ride)
                <li class="bg-gray-50 p-3 rounded-lg shadow">
                    <p class="font-semibold">{{ $ride->pickup_location }} → {{ $ride->dropoff_location }}</p>
                    <p class="text-gray-500 text-sm">{{ $ride->ride_time }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
