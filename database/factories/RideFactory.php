<?php

namespace Database\Factories;

use App\Models\Ride;
use Illuminate\Database\Eloquent\Factories\Factory;

class RideFactory extends Factory
{
    protected $model = Ride::class;

    public function definition()
    {
        return [
            'user_id' => 1, // Reference an existing user ID
            'driver_id' => 1, // Reference an existing driver ID
            'start_location' => $this->faker->address,
            'end_location' => $this->faker->address,
            'status' => 'pending', // Or 'completed', 'canceled', etc.
        ];
    }
}
