@extends('layouts.app')

@section('content')
<h1>🚖 Ride & Carpool Management</h1>

<table class="min-w-full bg-white shadow-md rounded-lg">
    <thead>
        <tr>
            <th class="p-2">Driver</th>
            <th class="p-2">User</th>
            <th class="p-2">Pickup</th>
            <th class="p-2">Dropoff</th>
            <th class="p-2">Carpool Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rides as $ride)
            <tr>
                <td class="p-2">{{ $ride->driver->name ?? 'N/A' }}</td>
                <td class="p-2">{{ $ride->user->name ?? 'N/A' }}</td>
                <td class="p-2">{{ $ride->pickup_location }}</td>
                <td class="p-2">{{ $ride->dropoff_location }}</td>
                <td class="p-2">{{ $ride->carpool_status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
