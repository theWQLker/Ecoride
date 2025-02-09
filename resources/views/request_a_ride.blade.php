@extends('layouts.app')

@section('content')
    <h1>🚖 Request a Ride</h1>
    <form action="{{ route('ride.request') }}" method="POST">
        @csrf
        <label>Pickup Location:</label>
        <input type="text" name="pickup_location" required>

        <label>Dropoff Location:</label>
        <input type="text" name="dropoff_location" required>

        <button type="submit">Request Ride</button>
    </form>
@endsection
