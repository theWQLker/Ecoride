@extends('layouts.app')

@section('content')
<h1>👤 User Dashboard</h1>
<p>View your ride history and book rides.</p>
<!-- 🚖 Request a Ride Button -->
<a href="{{ route('ride.request.view') }}" class="btn btn-primary">Request a Ride</a>
<!-- 🚖 View Ride History -->
<a href="{{ route('user.ride.history') }}" class="btn btn-secondary">View Ride History</a>

@endsection