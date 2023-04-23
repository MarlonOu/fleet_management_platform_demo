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
        Schema::create('123_vehicle_history_794935154', function (Blueprint $table) {
            $table->id();
            $table->integer('task_number');
            $table->char('date_time', 50);
            $table->integer('can_date_time');
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
            $table->char('longitude', 20);
            $table->char('latitude', 20);
            $table->char('altitude', 10);
            $table->tinyInteger('mil_signal');
            $table->char('vehicle_status', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('123_vehicle_history_794935154');
    }
};
