<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarpoolPassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert Carpool Passengers (users booking rides)
        DB::table('carpool_passengers')->insert([
            ['carpool_id' => 1, 'passenger_id' => 5, 'seats_booked' => 1, 'status' => 'pending'],
            ['carpool_id' => 2, 'passenger_id' => 6, 'seats_booked' => 1, 'status' => 'pending'],
            ['carpool_id' => 1, 'passenger_id' => 5, 'seats_booked' => 1, 'status' => 'pending'],
            ['carpool_id' => 2, 'passenger_id' => 6, 'seats_booked' => 1, 'status' => 'pending'],
        ]);
    }
}
