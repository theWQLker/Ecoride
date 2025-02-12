@extends('layouts.app')

@section('title', 'Driver Dashboard')

@section('content')
    <h1>🚗 Driver Dashboard</h1>
    <p>View available ride requests and manage your trips.</p>

    <h2>Welcome to your Dashboard, {{ Auth::user()->name }}</h2>
<p>Your role: <strong>{{ Auth::user()->role }}</strong></p>

    <!-- 🔍 View Available Rides Button -->
    <a href="{{ route('driver.rides_requested') }}" class="btn btn-primary">View Ride Requests</a>
    <!-- 🚘 View Accepted Rides -->
    <a href="{{ route('driver.assigned.rides') }}" class="btn btn-secondary">View Accepted Rides</a>
    <!-- 🚘 View Completed Rides -->
    <a href="{{ route('driver.ride.history') }}" class="btn btn-secondary">View Completed Rides</a>

@endsection
