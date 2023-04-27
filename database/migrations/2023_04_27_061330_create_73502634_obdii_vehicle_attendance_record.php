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
        Schema::create('73502634_obdii_vehicle_attendance_record', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_number');
            $table->char('task_start_time');
            $table->char('task_start_mileage');
            $table->char('task_end_time')->nullable();
            $table->char('task_end_mileage')->nullable();
            $table->tinyInteger('task_overtime');
            $table->integer('driver_number');
            $table->tinyInteger('driving_behavior_score')->nullable();
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
        Schema::dropIfExists('73502634_obdii_vehicle_attendance_record');
    }
};
