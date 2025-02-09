@extends('layouts.app')

@section('content')
    <h1>👑 Admin Dashboard</h1>
    <p>Manage users, monitor ride requests, and oversee system operations.</p>

    <!-- 👥 Manage Users Button -->
    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Manage Users</a>

    <!-- 🛞 View All Rides Button -->
    <a href="{{ route('admin.rides.index') }}" class="btn btn-secondary">View All Rides</a>
@endsection
