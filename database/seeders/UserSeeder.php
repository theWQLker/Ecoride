<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert Users with proper NULL handling for missing fields
        DB::table('users')->insert([
            ['email' => 'admin@ecoride.com', 'password' => Hash::make('Admin1234'), 'role' => 'admin', 'name' => 'Admin User', 'license_number' => null, 'driver_rating' => null],
            ['email' => 'driver1@ecoride.com', 'password' => Hash::make('Driver1234'), 'role' => 'driver', 'name' => 'John Doe', 'license_number' => 'D12345678', 'driver_rating' => 4.8],
            ['email' => 'driver2@ecoride.com', 'password' => Hash::make('Driver1234'), 'role' => 'driver', 'name' => 'Jane Smith', 'license_number' => 'D87654321', 'driver_rating' => 4.5],
            ['email' => 'driver3@ecoride.com', 'password' => Hash::make('Driver1234'), 'role' => 'driver', 'name' => 'Jane Smith', 'license_number' => 'D87655321', 'driver_rating' => 3.5],
            ['email' => 'user1@ecoride.com', 'password' => Hash::make('User1234'), 'role' => 'user', 'name' => 'Alice Brown', 'license_number' => null, 'driver_rating' => null],
            ['email' => 'user2@ecoride.com', 'password' => Hash::make('User1234'), 'role' => 'user', 'name' => 'Bob White', 'license_number' => null, 'driver_rating' => null],
            ['email' => 'user3@ecoride.com', 'password' => Hash::make('User1234'), 'role' => 'user', 'name' => 'Alice Bon', 'license_number' => null, 'driver_rating' => null],
            ['email' => 'user4@ecoride.com', 'password' => Hash::make('User1234'), 'role' => 'user', 'name' => 'Bob Jane', 'license_number' => null, 'driver_rating' => null],
            ['email' => 'user5@ecoride.com', 'password' => Hash::make('User1234'), 'role' => 'user', 'name' => 'Julius Jane', 'license_number' => null, 'driver_rating' => null],
        ]);
    }
}
