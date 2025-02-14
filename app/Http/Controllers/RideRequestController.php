<?php

namespace App\Http\Controllers;

use App\Models\RideRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class RideRequestController extends Controller
{
    /**
     * Affiche les demandes de trajets en attente pour le conducteur.
     * Displays pending ride requests for the driver.
     */
    public function index()
    {
        $rides = RideRequest::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        return view('driver.rides_requested', compact('rides'));
    }

    /**
     * Stocke une nouvelle demande de trajet.
     * Stores a new ride request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'ride_time' => 'required|date|after:now',
        ]);

        DB::beginTransaction();

        try {
            $ride = RideRequest::create([
                'user_id' => Auth::id(),
                'pickup_location' => $validated['pickup_location'],
                'dropoff_location' => $validated['dropoff_location'],
                'ride_time' => $validated['ride_time'],
                'status' => 'pending',
            ]);

            DB::commit();
            return redirect()->route('ride.request.view')->with('success', 'Ride request submitted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create ride request.');
        }
    }

    /**
     * Accepte une demande de trajet en tant que conducteur.
     * Accepts a ride request as a driver.
     */
    public function accept($id): RedirectResponse
    {
        $user = Auth::user();

        // Ensure the driver has a registered vehicle
        if (!$user->vehicle) {
            return redirect()->back()->with('error', 'You must register a vehicle before accepting rides.');
        }
        
        $ride = RideRequest::findOrFail($id);

        if ($ride->status !== 'pending') {
            return redirect()->back()->with('error', 'This ride request has already been taken.');
        }

        $ride->update([
            'driver_id' => Auth::id(),
            'status' => 'accepted',
        ]);

        return redirect()->route('driver.rides')->with('success', 'Ride request accepted.');
    }

    /**
     * Mark a ride request as completed.
     * Marque une demande de trajet comme terminée.
     */
    public function completeRide($id): RedirectResponse
    {
        $ride = RideRequest::findOrFail($id);

        if ($ride->status !== 'accepted') {
            return redirect()->back()->with('error', 'This ride cannot be completed yet.');
        }

        $ride->update(['status' => 'completed']);
        return redirect()->route('driver.ride.history')->with('success', 'Ride marked as completed.');
    }

    /**
     * Cancel a ride request.
     * Annule une demande de trajet.
     */
    public function cancel($id): RedirectResponse
    {
        $ride = RideRequest::findOrFail($id);

        if ($ride->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $ride->update(['status' => 'cancelled']);
        return redirect()->route('user.ride.history')->with('success', 'Ride request cancelled.');
    }

    /**
     * Display ride history for a user.
     * Affiche l'historique des trajets d'un utilisateur.
     */
    public function userRides()
    {
        $rides = RideRequest::where('user_id', Auth::id())->get();
        return view('user.ride_history', compact('rides'));
    }

    /**
     * Display assigned rides for a driver.
     * Affiche les trajets assignés à un conducteur.
     */
    public function assignedRides()
    {
        $rides = RideRequest::where('driver_id', Auth::id())->where('status', 'accepted')->get();
        return view('driver.assigned_rides', compact('rides'));
    }

    
    
    /**
     * Display completed rides for a driver.
     * Affiche les trajets terminés d'un conducteur.
     */
    public function driverRideHistory()
    {
        $rides = RideRequest::where('driver_id', Auth::id())->where('status', 'completed')->get();
        return view('driver.ride_history', compact('rides'));
    }
}
