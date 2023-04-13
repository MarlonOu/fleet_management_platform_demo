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
        Schema::create('123_vehicle_realtime_information', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_number');
            $table->tinyInteger('task_overtime');
            $table->integer('driver_number');
            $table->tinyInteger('driving_behavior_score');
            $table->integer('date_time');
            $table->integer('speed');
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
        Schema::dropIfExists('123_vehicle_realtime_information');
    }

};
