<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\RideRequest;
use App\Models\Vehicle;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_smoking',
        'pets_allowed',
        'accept_long_trips',
        'car_type_preference',
        'enjoys_music',
        'prefers_female_driver',
        'custom_preference',
    ];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'driver_id');
    }

    public function rides()
    {
        return $this->hasMany(RideRequest::class, 'user_id');
    }

    public function driverRides()
    {
        return $this->hasMany(RideRequest::class, 'driver_id');
    }

    /**
     * Get the attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Retrieve user preferences from MongoDB.
     */
    public function getPreferences()
    {
        return DB::connection('mongodb')
            ->table('user_preferences')
            ->where('user_id', $this->id)
            ->first() ?? (object) ['preferences' => []];
    }

    /**
     * Update user preferences in MongoDB.
     */
    public function updatePreferences(array $preferences)
    {
        $existingPreferences = $this->getPreferences();
        $mergedPreferences = array_replace_recursive((array) ($existingPreferences->preferences ?? []), $preferences);

        DB::connection('mongodb')->table('user_preferences')->updateOrInsert(
            ['user_id' => $this->id],
            ['preferences' => $mergedPreferences]
        );
    }
}
