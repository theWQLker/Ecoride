@extends('layouts.app')

@section('content')
    <h1>🚘 Your Accepted Rides</h1>

    @if ($rides->isEmpty())
        <p>You have no assigned rides at the moment.</p>
    @else
        @foreach ($rides as $ride)
            <div class="ride-request">
                <p><strong>Pickup:</strong> {{ $ride->pickup_location }}</p>
                <p><strong>Dropoff:</strong> {{ $ride->dropoff_location }}</p>
                <p><strong>Status:</strong> {{ ucfirst($ride->status) }}</p>
                
                @if ($ride->status === 'accepted')
                    <!-- Complete Ride Button -->
                    <form action="{{ route('ride.complete', $ride->id) }}" method="POST">
                        @csrf
                        <button type="submit">Mark as Completed</button>
                    </form>
                @endif
                <hr>
            </div>
        @endforeach
    @endif
@endsection
