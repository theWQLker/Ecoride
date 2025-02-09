@extends('layouts.app')

@section('content')
    <h1>Completed Rides</h1>

    @if ($rides->isEmpty())
        <p>You have not completed any rides yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pickup Location</th>
                    <th>Dropoff Location</th>
                    <th>Status</th>
                    <th>Completed At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rides as $ride)
                    <tr>
                        <td>{{ $ride->pickup_location }}</td>
                        <td>{{ $ride->dropoff_location }}</td>
                        <td>{{ ucfirst($ride->status) }}</td>
                        <td>{{ $ride->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
