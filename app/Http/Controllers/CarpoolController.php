<?php

namespace App\Http\Controllers;

use App\Models\Carpool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarpoolController extends Controller
{
    // Show all carpools
    // Afficher toutes les offres de covoiturage
    public function index()
    {
        $carpools = Carpool::where('status', 'upcoming')->get();
        return view('driver.carpools', compact('carpools'));
    }

    // Create a new carpool (Driver)
    // Créer un nouveau covoiturage (Conducteur)
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_location' => 'required|string',
            'end_location' => 'required|string',
            'departure_time' => 'required|date',
            'price_per_seat' => 'nullable|numeric',
        ]);

        $carpool = Carpool::create([
            'vehicle_id' => $request->vehicle_id,
            'driver_id' => Auth::id(),
            'start_location' => $request->start_location,
            'end_location' => $request->end_location,
            'departure_time' => $request->departure_time,
            'total_seats' => $request->total_seats,
            'available_seats' => $request->total_seats, // Initially all seats available // Initialement toutes les places sont disponibles
            'price_per_seat' => $request->price_per_seat,
            'status' => 'upcoming',
            'min_passengers' => 2, // Defined rule // Nombre minimum de passagers requis
        ]);

        return redirect()->route('driver.dashboard')->with('success', 'Carpool created successfully!'); // Covoiturage créé avec succès !
    }

    // Update carpool status (Admin or Driver)
    // Mettre à jour le statut du covoiturage (Admin ou Conducteur)
    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:upcoming,in progress,completed,canceled'
        ]);

        $carpool = Carpool::findOrFail($id);
        $carpool->update(['status' => $request->status]);

        return redirect()->route('admin.rides.index')->with('success', 'Carpool status updated!'); // Statut du covoiturage mis à jour !
    }

    // Delete carpool (Admin only)
    // Supprimer un covoiturage (Administrateur uniquement)
    public function destroy($id)
    {
        $carpool = Carpool::findOrFail($id);
        $carpool->delete();

        return redirect()->route('admin.rides.index')->with('success', 'Carpool deleted successfully!'); // Covoiturage supprimé avec succès !
    }
}
