<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_history_obdii_476823601', function (Blueprint $table) {
            $table->id();
            $table->integer('task_number');
            $table->char('date_time', 50);
            $table->char('speed', 15);
            $table->char('engine_speed', 15);
            $table->char('oxygen_sensor');
            $table->char('short_fuel');
            $table->char('fuel_rate');
            $table->char('mass_air_flow');
            $table->char('air_fuel_ratio');
            $table->char('can_date_time');
            $table->char('longitude', 20);
            $table->char('latitude', 20);
            $table->char('altitude', 10);
            $table->char('vehicle_status', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_history_obdii_476823601');
    }
};
