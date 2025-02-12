<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carpool extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id', 'driver_id', 'start_location', 'end_location', 'departure_time', 'total_seats', 'available_seats', 'status', 'price_per_seat', 'min_passengers'
    ];

    // Relationship with Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    // Relationship with User (Driver)
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
