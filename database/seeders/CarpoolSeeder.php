<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarpoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert Carpools
        DB::table('carpools')->insert([
            ['vehicle_id' => 1, 'driver_id' => 2, 'start_location' => 'Downtown', 'end_location' => 'Airport', 'departure_time' => '2025-02-15 08:00:00', 'total_seats' => 4, 'available_seats' => 4, 'status' => 'upcoming', 'price_per_seat' => 10.00, 'min_passengers' => 2],
            ['vehicle_id' => 2, 'driver_id' => 3, 'start_location' => 'City Center', 'end_location' => 'University', 'departure_time' => '2025-02-16 09:30:00', 'total_seats' => 4, 'available_seats' => 3, 'status' => 'upcoming', 'price_per_seat' => 8.00, 'min_passengers' => 2],
        ]);
    }
}
