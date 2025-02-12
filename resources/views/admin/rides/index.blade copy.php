 @extends('layouts.app')

@section('title', 'Admin Ride Management')

@section('content')
    <h1>🚗 Admin Ride Management</h1>

    @if ($rides->isEmpty())
        <p>No rides available at the moment.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Driver</th>
                    <th>Status</th>
                    <th>Pickup Location</th>
                    <th>Dropoff Location</th>
                    <th>Ride Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rides as $ride)
                    <tr>
                        <!-- Safely check if user and driver exist -->
                        <td>{{ optional($ride->user)->name ?? 'No user assigned' }}</td>
                        <td>{{ optional($ride->driver)->name ?? 'No driver assigned' }}</td>
                        <td>{{ ucfirst($ride->status) }}</td>
                        <td>{{ $ride->pickup_location }}</td>
                        <td>{{ $ride->dropoff_location }}</td>
                        <td>{{ $ride->ride_time ? $ride->ride_time->format('d-m-Y H:i') : 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
