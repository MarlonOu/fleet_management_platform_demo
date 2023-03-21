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
        Schema::create('j1939_vehicle_realtime_data', function (Blueprint $table) {
            $table->id();
            $table->char('vehicle_number', 50);
            $table->tinyInteger('task_overtime');
            $table->char('driver_number', 11);
            $table->integer('driving_behavior_score');
            $table->char('date_time', 50);
            $table->char('speed', 15);
            $table->char('engine_speed', 15);
            $table->char('app1', 10);
            $table->char('bpp', 10);
            $table->char('torque', 10);
            $table->char('instant_fuel', 15);
            $table->char('average_fuel', 15);
            $table->char('odo_mileage', 25);
            $table->char('idle_hours', 20);
            $table->char('idle_fuel', 15);
            $table->char('brake_state', 10);
            $table->char('ap1_lis', 10);
            $table->char('can_date_time', 50);
            $table->char('longitude', 20);
            $table->char('latitude', 20);
            $table->char('altitude', 10);
            $table->tinyInteger('mil_signal');
            $table->char('vehicle_status', 10);
            $table->char('driving_behavior_warning', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('j1939_vehicle_realtime_data');
    }
};
