<?php

namespace App\Http\Controllers;

use App\Models\RideRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RideRequestController extends Controller
{
    public function index()
    {
        // Show pending ride requests for drivers
        $rides = RideRequest::where('status', 'pending')->get();
        return view('driver.rides_requested', compact('rides'));
    }

    public function driverRideHistory()
    {
        // Retrieve rides that this driver has completed
        $rides = RideRequest::where('driver_id', Auth::id())
            ->where('status', 'completed')
            ->get();

        return view('driver.ride_history', compact('rides'));
    }

    public function store(Request $request)
    {
        // User submits a ride request
        $request->validate([
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
        ]);

        RideRequest::create([
            'user_id' => Auth::id(),
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Ride request sent!');
    }
    public function userRides()
    {
        // Retrieve all rides requested by the logged-in user
        $rides = RideRequest::where('user_id', Auth::id())->get();

        return view('user.ride_history', compact('rides'));
    }

    public function assignedRides()
    {
        // Retrieve rides assigned to the logged-in driver
        $rides = RideRequest::where('driver_id', Auth::id())
            ->where('status', 'accepted')
            ->get();

        return view('driver.assigned_rides', compact('rides'));
    }
    public function accept($id)
    {
        // Driver accepts a ride request
        $ride = RideRequest::findOrFail($id);

        if ($ride->status !== 'pending' || $ride->driver_id !== null) {
            return redirect()->route('driver.rides')->with('error', 'This ride has already been taken.');
        }

        $ride->update([
            'driver_id' => Auth::id(),
            'status' => 'accepted',
        ]);

        return redirect()->route('driver.dashboard')->with('success', 'Ride accepted!');
    }
    public function completeRide($id)
    {
        $ride = RideRequest::findOrFail($id);

        // Ensure only the assigned driver can mark the ride as completed
        if (Auth::id() !== $ride->driver_id) {
            return redirect()->route('driver.assigned.rides')->with('error', 'You are not assigned to this ride.');
        }

        $ride->update(['status' => 'completed']);

        return redirect()->route('driver.assigned.rides')->with('success', 'Ride marked as completed.');
    }

    public function cancelRide($id)
{
    $ride = RideRequest::findOrFail($id);

    // Users can only cancel their own rides if they are still pending
    if (Auth::id() !== $ride->user_id || $ride->status !== 'pending') {
        return redirect()->route('user.ride.history')->with('error', 'You cannot cancel this ride.');
    }

    $ride->update(['status' => 'canceled']);

    return redirect()->route('user.ride.history')->with('success', 'Ride canceled.');
}


    public function cancel($id)
    {
        // User cancels a ride
        $ride = RideRequest::findOrFail($id);
        $ride->update(['status' => 'canceled']);

        return redirect()->route('user.dashboard')->with('success', 'Ride canceled.');
    }
}
