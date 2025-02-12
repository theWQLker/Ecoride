@extends('layouts.app')

@section('title', 'Driver Profile')

@section('content')
    <h1>🚗 Driver Profile</h1>
    <p>Manage your vehicle and preferences.</p>

    <h2>Hello, {{ Auth::user()->name }}</h2>
    <p>Your role: <strong>{{ Auth::user()->role }}</strong></p>

    <h3>Your Vehicle</h3>
    <p>Model: {{ $vehicle->model ?? 'Not registered' }}</p>
    <p>Plate: {{ $vehicle->plate_number ?? 'Not registered' }}</p>
    <p>Fuel: {{ $vehicle->fuel_type ?? 'Not registered' }}</p>

    <h3>Your Preferences</h3>
    <p>No Smoking: {{ Auth::user()->no_smoking ? 'Yes' : 'No' }}</p>
    <p>Pets Allowed: {{ Auth::user()->pets_allowed ? 'Yes' : 'No' }}</p>
    <p>Music Preference: {{ Auth::user()->music_preference ? 'Yes' : 'No' }}</p>
@endsection
