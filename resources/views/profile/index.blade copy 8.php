@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-semibold">Profile</h2>

    <!-- Profile Picture & User Info -->
    <div class="flex items-center space-x-4 mt-4 border-b pb-4">
        <img src="{{ Auth::user()->profile_picture ?? 'https://via.placeholder.com/100' }}" alt="Profile Picture" class="w-20 h-20 rounded-full">
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
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Update Vehicle Info</button>
        </form>
        @else
        <p class="text-red-500">No vehicle registered. You cannot accept rides.</p>
        <form method="POST" action="{{ route('profile.driver.vehicle.update') }}">
            @csrf
            <input type="text" name="model" placeholder="Model" required class="border rounded px-3 py-2 w-full mb-2">
            <input type="text" name="plate_number" placeholder="Plate Number" required class="border rounded px-3 py-2 w-full mb-2">
            <input type="text" name="fuel_type" placeholder="Fuel Type" required class="border rounded px-3 py-2 w-full mb-2">
            <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg">Register Vehicle</button>
        </form>
        @endif
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
        <ul>
            @foreach ($user->rides as $ride)
            <li class="p-2 border-b">
                <strong>{{ $ride->pickup_location }}</strong> → {{ $ride->dropoff_location }}
                <span class="text-gray-500">{{ $ride->ride_time }}</span>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-gray-500">No completed rides yet.</p>
        @endif
        @elseif (Auth::user()->role === 'driver')
        @if ($user->driverRides && $user->driverRides->isNotEmpty())
        <ul>
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
        <button class="bg-green-500 text-white px-6 py-2 rounded-lg">Save Profile</button>
    </div>
</div>
@endsection