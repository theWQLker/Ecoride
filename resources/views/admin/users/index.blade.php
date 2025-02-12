@extends('layouts.app')

@section('content')
<h1>🚀 User Management</h1>

<!-- Role-based User Sections -->
@foreach (['admin', 'driver', 'user'] as $role)
    <h2 class="mt-6 text-xl font-semibold">{{ ucfirst($role) }}s</h2>
    <ul class="bg-white shadow-md p-4 rounded-lg">
        @foreach ($users->where('role', $role) as $user)
            <li class="p-2 border-b flex justify-between">
                <span>{{ $user->name }} ({{ $user->email }})</span>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500">Edit</a>
            </li>
        @endforeach
    </ul>
@endforeach
@endsection
