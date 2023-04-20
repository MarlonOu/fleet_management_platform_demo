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
        Schema::create('123_commercial_vehicle_specification', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_number');
            $table->char('licence_plate',8);
            $table->char('emission_standards',10);
            $table->string('manufacturer',30);
            $table->string('vehicle_model',30);
            $table->string('eco_level',30);
            $table->string('total_weight',30);
            $table->string('chasse_weight',30);
            $table->string('wheelbase',30);
            $table->string('engine_type');
            $table->string('volume',30);
            $table->string('horse_power',30);
            $table->string('torque_max',30);
            $table->string('transmission_type',30);
            $table->string('shift_no',30);
            $table->float('rear_axle_ratio');
            $table->string('generator_current',30);
            $table->string('main_brake');
            $table->string('aux_brake');
            $table->string('abs',30);
            $table->string('suspension_front_axle', 30);
            $table->string('suspension_rear_axle', 30);
            $table->string('fuel_tank_Volume', 30);
            $table->string('licence_plate_no', 30);
            $table->char('emission_standard', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('123_commercial_vehicle_specification');
    }
};
