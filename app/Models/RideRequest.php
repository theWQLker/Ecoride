<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'driver_id',
        'pickup_location',
        'dropoff_location',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    public function index()
    {
        // Retrieve only pending ride requests that haven't been assigned to a driver yet
        $rides = RideRequest::where('status', 'pending')->whereNull('driver_id')->get();

        return view('driver.ride_requests', compact('rides'));
    }
}
