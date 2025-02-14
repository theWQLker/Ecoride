<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RideRequest;
use App\Models\Carpool;

class AdminController extends Controller
{
    // Show all users (Admin Panel)
    public function users()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Show all rides (Admin Panel)
    public function rides()
    {
        $rides = RideRequest::all();
        return view('admin.rides.index', compact('rides'));
    }

    public function viewRides()
    {
        $rides = RideRequest::with(['user',
            'driver'
        ])->get();
        return view('admin.rides', compact('rides'));
    }

    // Show all carpools (Admin Panel)
    public function carpools()
    {
        $carpools = Carpool::all();
        return view('admin.carpools.index', compact('carpools'));
    }
}
