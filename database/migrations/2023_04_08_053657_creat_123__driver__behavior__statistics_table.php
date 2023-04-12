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
        Schema::create('123_driver_behavior_statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('employ_id');
            $table->char('month', 50);
            $table->integer('average score');
            $table->integer('violation');
            $table->integer('mistake/error',);
            $table->integer('slip/lapse');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('123_driver_behavior_statistics');
    }
};
