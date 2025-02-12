<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert Vehicles (one car per driver)
        DB::table('vehicles')->insert([
            ['driver_id' => 2, 'registration_number' => 'ABC-1234', 'model' => 'Toyota Prius', 'energy_type' => 'hybrid', 'total_seats' => 4, 'ecological_rating' => 4.5],
            ['driver_id' => 3, 'registration_number' => 'XYZ-5678', 'model' => 'Tesla Model 3', 'energy_type' => 'electric', 'total_seats' => 4, 'ecological_rating' => 5.0],
            ['driver_id' => 4, 'registration_number' => 'XrZ-4767', 'model' => 'Tesla Model Y', 'energy_type' => 'electric', 'total_seats' => 4, 'ecological_rating' => 5.0],
        ]);
    }
}
