@extends('layouts.app')

@section('content')
<h1>🚖 Request a Ride</h1>
<form method="POST" action="{{ route('ride.request') }}">
    @csrf
    <label for="pickup_location">Pickup Location:</label>
    <input type="text" name="pickup_location" required>

    <label for="dropoff_location">Dropoff Location:</label>
    <input type="text" name="dropoff_location" required>

    <label for="ride_time">Ride Time:</label>
    <input type="datetime-local" name="ride_time" required>

    <button type="submit">Request Ride</button>
</form>

@endsection