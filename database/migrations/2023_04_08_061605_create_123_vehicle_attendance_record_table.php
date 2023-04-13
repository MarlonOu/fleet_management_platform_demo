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
        Schema::create('123_vehicle_attendance_record', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_number');
            $table->integer('task_start_time');
            $table->integer('task_start_mileage');
            $table->integer('task_end_time')->nullable();
            $table->integer('task_end_mileage')->nullable();
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
        Schema::dropIfExists('123_vehicle_attendance_record');
    }
};
