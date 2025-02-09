@extends('layouts.app')

@section('content')
    <h1>Your Ride History</h1>

    @if ($rides->isEmpty())
        <p>You have not requested any rides yet.</p>
    @else
        @foreach ($rides as $ride)
            <div class="ride-request">
                <p><strong>Pickup:</strong> {{ $ride->pickup_location }}</p>
                <p><strong>Dropoff:</strong> {{ $ride->dropoff_location }}</p>
                <p><strong>Status:</strong> {{ ucfirst($ride->status) }}</p>
                @if ($ride->driver_id)
                    <p><strong>Driver Assigned:</strong> {{ $ride->driver->name }}</p>
                @else
                    <p><strong>Driver Assigned:</strong> Not yet assigned</p>
                @endif

                @if ($ride->status == 'pending')
                    <!-- Cancel Ride Button -->
                    <form action="{{ route('ride.cancel', $ride->id) }}" method="POST">
                        @csrf
                        <button type="submit">Cancel Ride</button>
                    </form>
                @endif
                <hr>
            </div>
        @endforeach
    @endif
@endsection
