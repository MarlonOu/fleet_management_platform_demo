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
        Schema::create('73502634_obdii_driver_information', function (Blueprint $table) {
            $table->id();
            $table->integer('employ_id');
            $table->char('driver_name', 50);
            $table->integer('driver_number');
            $table->char('sex', 50);
            $table->date('birthday');
            $table->char('tel', 50);
            $table->char('address', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('73502634_obdii_driver_information');
    }
};
