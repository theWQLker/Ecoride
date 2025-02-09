<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ride_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Requester
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null'); // Assigned driver
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->enum('status', ['pending', 'accepted', 'completed', 'canceled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ride_requests');
    }
};
