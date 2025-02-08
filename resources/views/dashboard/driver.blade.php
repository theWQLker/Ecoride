@extends('layouts.dashboard')

@section('title', 'Driver Dashboard')

@section('content')
    <h1>🚗 Driver Dashboard</h1>
    <p>View available ride requests and manage your trips.</p>

    <h2>Welcome to your Dashboard, {{ Auth::user()->name }}</h2>
<p>Your role: <strong>{{ Auth::user()->role }}</strong></p>
@endsection
