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
        Schema::create('j1939_vehicle_attendance_record', function (Blueprint $table) {
            $table->id();
            $table->char('vehicle_number', 50);
            $table->char('task_start_time', 50);
            $table->integer('task_start_mileage');
            $table->char('task_end_time', 50)->nullable();
            $table->integer('task_end_mileage')->nullable();
            $table->tinyInteger('task_overtime');
            $table->char('driver_number', 11);
            $table->integer('driving_behavior_score')->nullable();
            $table->float('co2_emission')->nullable();
            $table->float('pm_generated')->nullable();
            $table->tinyInteger('task_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('j1939_vehicle_attendance_record');
    }
};
