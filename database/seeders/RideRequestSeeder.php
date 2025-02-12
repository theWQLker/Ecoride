<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RideRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ride_requests')->insert([
            ['carpool_id' => 1, 'driver_id' => 2, 'pickup_location' => 'Downtown', 'dropoff_location' => 'Airport', 'ride_time' => '2025-02-15 08:00:00', 'status' => 'pending', 'user_id' => 5],
            ['carpool_id' => 2, 'driver_id' => 3, 'pickup_location' => 'City Center', 'dropoff_location' => 'University', 'ride_time' => '2025-02-16 09:30:00', 'status' => 'pending', 'user_id' => 6],
            ['carpool_id' => 1, 'driver_id' => 2, 'pickup_location' => 'Downtown', 'dropoff_location' => 'Mall', 'ride_time' => '2025-02-17 14:00:00', 'status' => 'pending', 'user_id' => 5],
            ['carpool_id' => 2, 'driver_id' => 3, 'pickup_location' => 'City Center', 'dropoff_location' => 'Train Station', 'ride_time' => '2025-02-18 18:00:00', 'status' => 'pending', 'user_id' => 6],
            ['carpool_id' => 1, 'driver_id' => 2, 'pickup_location' => 'Downtown', 'dropoff_location' => 'Office Park', 'ride_time' => '2025-02-19 07:00:00', 'status' => 'pending', 'user_id' => 5],
            ['carpool_id' => 2, 'driver_id' => 3, 'pickup_location' => 'Uptown', 'dropoff_location' => 'Mall', 'ride_time' => '2025-02-20 10:00:00', 'status' => 'accepted', 'user_id' => 7],
            ['carpool_id' => 2, 'driver_id' => 2, 'pickup_location' => 'Suburbs', 'dropoff_location' => 'Airport', 'ride_time' => '2025-02-21 11:30:00', 'status' => 'pending', 'user_id' => 6],
            ['carpool_id' => 2, 'driver_id' => 3, 'pickup_location' => 'Downtown', 'dropoff_location' => 'Train Station', 'ride_time' => '2025-02-23 16:00:00', 'status' => 'pending', 'user_id' => 6],
            ['carpool_id' => 2, 'driver_id' => 2, 'pickup_location' => 'Uptown', 'dropoff_location' => 'Mall', 'ride_time' => '2025-02-24 18:30:00', 'status' => 'accepted', 'user_id' => 7],
            ['carpool_id' => 1, 'driver_id' => 3, 'pickup_location' => 'Suburbs', 'dropoff_location' => 'Office Park', 'ride_time' => '2025-02-25 07:45:00', 'status' => 'pending', 'user_id' => 8],
        ]);
    }
}
