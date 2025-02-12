<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarpoolPassenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'carpool_id', 'passenger_id', 'seats_booked', 'status'
    ];

    // Relationship with Carpool
    public function carpool()
    {
        return $this->belongsTo(Carpool::class, 'carpool_id');
    }

    // Relationship with User (Passenger)
    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }
}
