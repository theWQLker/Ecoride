@extends('layouts.app')

@section('content')
    <h1>Available Ride Requests</h1>

    @if ($rides->isEmpty())
        <p>No available ride requests at the moment.</p>
    @else
        @foreach ($rides as $ride)
            <div class="ride-request">
                <p><strong>Pickup:</strong> {{ $ride->pickup_location }}</p>
                <p><strong>Dropoff:</strong> {{ $ride->dropoff_location }}</p>
                <form action="{{ route('ride.accept', $ride->id) }}" method="POST">
                    @csrf
                    <button type="submit">Accept Ride</button>
                </form>
                <hr>
            </div>
        @endforeach
    @endif
@endsection
