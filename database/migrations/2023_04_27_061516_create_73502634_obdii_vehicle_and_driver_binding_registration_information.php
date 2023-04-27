<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('73502634_obdii_vehicle_and_driver_binding_registration_info', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_number');
            $table->integer('driver_number');
            $table->integer('bind_mileage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('73502634_obdii_vehicle_and_driver_binding_registration_info');
    }
};
