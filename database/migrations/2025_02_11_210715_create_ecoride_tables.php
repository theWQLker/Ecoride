<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Create Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT PRIMARY KEY
            $table->string('email')->unique();
            $table->string('password'); // Laravel uses bcrypt
            $table->enum('role', ['admin', 'driver', 'user']);
            $table->string('name');
            $table->string('license_number')->nullable();
            $table->decimal('driver_rating', 3, 2)->nullable();
            $table->rememberToken(); // Required for authentication persistence
            $table->timestamps(); // created_at & updated_at
        });

        // Create Vehicles Table
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('users')->cascadeOnDelete();
            $table->string('registration_number')->unique();
            $table->string('model');
            $table->string('energy_type', 50);
            $table->integer('total_seats');
            $table->decimal('ecological_rating', 3, 2)->nullable();
            $table->timestamps();
        });

        // Create Carpools Table
        Schema::create('carpools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained('users')->cascadeOnDelete();
            $table->string('start_location');
            $table->string('end_location');
            $table->dateTime('departure_time');
            $table->integer('total_seats');
            $table->integer('available_seats');
            $table->enum('status', ['upcoming', 'in progress', 'completed', 'canceled'])->default('upcoming');
            $table->decimal('price_per_seat', 10, 2)->nullable();
            $table->integer('min_passengers')->default(2);
            $table->timestamps();
        });

        // Create Carpool Passengers Table
        Schema::create('carpool_passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carpool_id')->constrained('carpools')->cascadeOnDelete();
            $table->foreignId('passenger_id')->constrained('users')->cascadeOnDelete();
            $table->integer('seats_booked');
            $table->enum('status', ['pending', 'confirmed', 'in progress', 'completed', 'canceled'])->default('pending');
            $table->timestamps();
        });

        // Create Ride Requests Table
        Schema::create('ride_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('carpool_id')->nullable()->constrained('carpools')->nullOnDelete();
            $table->enum('status', ['pending', 'accepted', 'completed', 'canceled'])->default('pending');
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->dateTime('ride_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_requests');
        Schema::dropIfExists('carpool_passengers');
        Schema::dropIfExists('carpools');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('users');
    }
};