<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Run the individual seeders
        $this->call([
            UserSeeder::class,
            VehicleSeeder::class,
            CarpoolSeeder::class,
            RideRequestSeeder::class,
            CarpoolPassengerSeeder::class, // Assuming you want a separate seeder for carpool_passengers
        ]);
    }
}
