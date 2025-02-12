<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideRequest extends Model
{
    use HasFactory;
    
    protected $table = 'ride_requests'; // Assure que le bon nom de table est utilisé
    protected $connection = 'mysql'; // S'assure que MySQL est utilisé

    protected $fillable = [
        'user_id',
        'driver_id',
        'carpool_id',
        'pickup_location',
        'dropoff_location',
        'ride_time',
        'status'
    ];
    
    protected $casts = [
        'ride_time' => 'datetime', // Convertir ride_time en instance Carbon
    ];

    /**
     * Relation avec l'utilisateur qui a fait la demande.
     * Relation to the user who made the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le conducteur assigné.
     * Relation to the assigned driver.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Relation avec le covoiturage une fois accepté.
     * Relation to the carpool once accepted.
     */
    public function carpool()
    {
        return $this->belongsTo(Carpool::class, 'carpool_id');
    }
}
