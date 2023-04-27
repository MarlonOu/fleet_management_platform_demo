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
        Schema::create('73502634_obdii_vehicle_realtime_information', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_number');
            $table->tinyInteger('task_overtime');
            $table->integer('driver_number');
            $table->tinyInteger('driving_behavior_score');
            $table->char('date_time');
            $table->char('speed');
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
            $table->tinyInteger('vehicle_status');
            $table->tinyInteger('driving_behavior_warning');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('73502634_obdii_vehicle_realtime_information');
    }

};
