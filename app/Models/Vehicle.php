<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id', 'registration_number', 'model', 'energy_type', 'total_seats', 'ecological_rating'
    ];

    // Relationship with User (Driver)
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
