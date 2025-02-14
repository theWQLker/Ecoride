@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-semibold">Profile</h2>

    <!-- Profile Picture & User Info -->
    <div class="flex items-center space-x-4 mt-4 border-b pb-4">
    <img src="{{ Auth::user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" alt="Profile Picture" class="w-20 h-20 rounded-full">
    <div>
            <h3 class="text-lg font-bold">{{ Auth::user()->name }}</h3>
            <p class="text-gray-500">Role: {{ ucfirst(Auth::user()->role) }}</p>
        </div>
    </div>

    <!-- Wallet & Rating -->
    @if (Auth::user()->role !== 'admin')
    <div class="flex justify-between mt-4">
        <div>
            <h4 class="font-semibold">Wallet</h4>
            <p class="text-xl font-bold">€{{ Auth::user()->wallet_balance ?? '0.00' }}</p>
        </div>
        <div>
            <h4 class="font-semibold">Rating</h4>
            <p class="text-xl">⭐ {{ Auth::user()->rating ?? 'N/A' }}</p>
        </div>
    </div>
    @endif

    <!-- Driver Vehicle Information -->
    @if (Auth::user()->role === 'driver')
    <div class="mt-6 p-4 bg-gray-50 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Vehicle Information</h3>
        @if(Auth::user()->vehicle)
        <p><strong>Model:</strong> {{ Auth::user()->vehicle->model }}</p>
        <p><strong>Plate Number:</strong> {{ Auth::user()->vehicle->plate_number }}</p>
        <p><strong>Fuel Type:</strong> {{ Auth::user()->vehicle->fuel_type }}</p>
        <form method="POST" action="{{ route('profile.driver.vehicle.update') }}" class="mt-4">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Update Vehicle Info</button>
        </form>
        @else
        <p class="text-red-500">No vehicle registered. You cannot accept rides.</p>
        <form method="POST" action="{{ route('profile.driver.vehicle.update') }}">
            @csrf
            @method('PATCH')
            <input type="text" name="model" placeholder="Model" required class="border rounded px-3 py-2 w-full mb-2">
            <input type="text" name="plate_number" placeholder="Plate Number" required class="border rounded px-3 py-2 w-full mb-2">
            <input type="text" name="fuel_type" placeholder="Fuel Type" required class="border rounded px-3 py-2 w-full mb-2">
            <button type="submit" class="mt-4 bg-blue text-black px-4 py-2 rounded-lg">Register Vehicle</button>
        </form>
        @endif
    </div>
    @endif

    <!-- Preferences (Hidden for Admin) -->
    <!-- Preferences Section -->
    @if (Auth::user()->role !== 'admin')
    <div class="mt-6 p-4 bg-gray-50 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Preferences</h3>
        <!-- Preferences Display (MongoDB Data) -->
        @if (isset($preferences))
        <div class="p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Preferences</h3>
            <p><strong>Smoking Allowed:</strong> {{ $preferences['smoking_allowed'] ? 'Yes' : 'No' }}</p>
            <p><strong>Pets Allowed:</strong> {{ $preferences['animals_allowed'] ? 'Yes' : 'No' }}</p>

            @if (!empty($preferences['additional_preferences']))
            <p><strong>Additional Preferences:</strong> {{ implode(', ', $preferences['additional_preferences']) }}</p>
            @endif
        </div>
        @endif

        <form method="POST" action="{{ route('profile.updatePreferences') }}">
    @csrf

    <!-- Preferences Section -->
    <div id="visible-preferences">
        @if (Auth::user()->role === 'driver')
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="no_smoking" {{ !empty($preferences['no_smoking']) ? 'checked' : '' }} class="rounded border-gray-300">
                <span>No Smoking</span>
            </label>
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="pets_allowed" {{ !empty($preferences['pets_allowed']) ? 'checked' : '' }} class="rounded border-gray-300">
                <span>Pets Allowed</span>
            </label>
        @else
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="enjoys_music" {{ !empty($preferences['enjoys_music']) ? 'checked' : '' }} class="rounded border-gray-300">
                <span>Enjoys Music</span>
            </label>
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="prefers_female_driver" {{ !empty($preferences['prefers_female_driver']) ? 'checked' : '' }} class="rounded border-gray-300">
                <span>Prefers Female Driver</span>
            </label>
        @endif
    </div>

    <!-- More Preferences Dropdown -->
    <div class="mt-3">
        <button type="button" onclick="toggleDropdown()" class="bg-gray-300 px-3 py-2 rounded-lg">More Preferences</button>
        <div id="extra-preferences" class="hidden mt-3">
            @if (Auth::user()->role === 'driver')
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="accept_long_trips" {{ !empty($preferences['accept_long_trips']) ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>Accept Long Trips</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="car_type_preference" {{ !empty($preferences['car_type_preference']) ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>Car Type Preference</span>
                </label>
            @else
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="no_smoking" {{ !empty($preferences['no_smoking']) ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>No Smoking</span>
                </label>
            @endif
        </div>
    </div>

    <!-- Display Existing Custom Preferences -->
    @if (!empty($preferences['custom_preferences']))
        <div class="mt-4">
            <h3 class="text-lg font-semibold mb-2">Custom Preferences</h3>
            <ul>
                @foreach ($preferences['custom_preferences'] as $customPref)
                    <li class="text-gray-600">{{ $customPref }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Custom Preference Input -->
    <label class="flex items-center space-x-2 mt-4">
        <input type="text" name="custom_preference" placeholder="Add a custom preference..." class="rounded border-gray-300 px-3 py-1 w-full">
    </label>

    <button type="submit" class="mt-4 bg-black text-white px-4 py-2 rounded-lg">Save Preferences</button>
</form>

        <!-- <form method="POST" action="{{ route('profile.updatePreferences') }}">
            @csrf

            <!-- Visible Preferences (2-3 per role) -->
            <!-- <div id="visible-preferences">
                @if (Auth::user()->role === 'driver')
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="no_smoking" {{ Auth::user()->no_smoking ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>No Smoking</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="pets_allowed" {{ Auth::user()->pets_allowed ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>Pets Allowed</span>
                </label>
                @else
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="enjoys_music" {{ Auth::user()->enjoys_music ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>Enjoys Music</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="prefers_female_driver" {{ Auth::user()->prefers_female_driver ? 'checked' : '' }} class="rounded border-gray-300">
                    <span>Prefers Female Driver</span>
                </label>
                @endif
            </div> -->

            <!-- Dropdown for Extra Preferences -->
            <!-- <div class="mt-3">
                <button type="button" onclick="toggleDropdown()" class="bg-gray-300 px-3 py-2 rounded-lg">More Preferences</button>
                <div id="extra-preferences" class="hidden mt-3">
                    @if (Auth::user()->role === 'driver')
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="accept_long_trips" {{ Auth::user()->accept_long_trips ? 'checked' : '' }} class="rounded border-gray-300">
                        <span>Accept Long Trips</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="car_type_preference" {{ Auth::user()->car_type_preference ? 'checked' : '' }} class="rounded border-gray-300">
                        <span>Car Type Preference</span>
                    </label>
                    @else
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="no_smoking" {{ Auth::user()->no_smoking ? 'checked' : '' }} class="rounded border-gray-300">
                        <span>No Smoking</span>
                    </label>
                    @endif
                </div>
            </div> -->

            <!-- Custom Preference Input -->
            <!-- <label class="flex items-center space-x-2 mt-4">
                <input type="text" name="custom_preference" placeholder="Add a custom preference..." class="rounded border-gray-300 px-3 py-1 w-full">
            </label> -->

            <!-- <button type="submit" class="mt-4 bg-black text-white px-4 py-2 rounded-lg">Save Preferences</button>
        </form>  -->
    </div>
    @endif


    <!-- Ride History
    @if (Auth::user()->role !== 'admin')
    <div class="mt-6 p-4 bg-gray-50 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Ride History</h3>

        
        @if (Auth::user()->role === 'user' && $user->rides->isEmpty())
            <p class="text-gray-500">No completed rides yet.</p>
        @elseif (Auth::user()->role === 'driver' && $user->driverRides->isEmpty())
            <p class="text-gray-500">No completed rides yet.</p>
        @else
            <ul>
                @if (Auth::user()->role === 'user')
                    @foreach ($user->rides as $ride)
                        <li class="p-2 border-b">
                            <strong>{{ $ride->pickup_location }}</strong> → {{ $ride->dropoff_location }} 
                            <span class="text-gray-500">{{ $ride->ride_time }}</span>
                        </li>
                    @endforeach
                @elseif (Auth::user()->role === 'driver')
                    @foreach ($user->driverRides as $ride)
                        <li class="p-2 border-b">
                            <strong>{{ $ride->pickup_location }}</strong> → {{ $ride->dropoff_location }} 
                            <span class="text-gray-500">{{ $ride->ride_time }}</span>
                        </li>
                    @endforeach
                @endif
            </ul>
        @endif
    </div>
    @endif -->

    <!-- Ride History -->
    @if (Auth::user()->role !== 'admin')
    <div class="mt-6 p-4 bg-gray-50 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Ride History</h3>

        @if (Auth::user()->role === 'user')
        @if ($user->rides && $user->rides->isNotEmpty())

        <ul class="divide-y divide-gray-200">
            @foreach ($user->rides as $ride)
            <li class="p-4 border rounded-lg shadow bg-white my-2">
                <div class="font-semibold">{{ $ride->pickup_location }} → {{ $ride->dropoff_location }}</div>
                <div class="text-sm text-gray-500">{{ $ride->ride_time }}</div>
            </li>
            @endforeach
        </ul>

        @else
        <p class="text-gray-500">No completed rides yet.</p>
        @endif
        @elseif (Auth::user()->role === 'driver')
        @if ($user->driverRides && $user->driverRides->isNotEmpty())
        <ul class="divide-y divide-gray-200">
            @foreach ($user->driverRides as $ride)
            <li class="p-2 border-b">
                <strong>{{ $ride->pickup_location }}</strong> → {{ $ride->dropoff_location }}
                <span class="text-gray-500">{{ $ride->ride_time }}</span>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-gray-500">No completed rides yet.</p>
        @endif
        @endif
    </div>
    @endif


    <!-- Save Profile Button -->
    <div class="mt-6 text-center">
        <button class="bg-blue text-black px-6 py-2 rounded-lg">Save Profile</button>
    </div>
</div>

<script>
    function toggleDropdown() {
        document.getElementById('extra-preferences').classList.toggle('hidden');
    }
</script>

@endsection