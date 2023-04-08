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
        Schema::create('123_Driver_Behavior_Statistics_table', function (Blueprint $table) {
            $table->id();
            $table->integer('Employ_ID');
            $table->char('Month', 50);
            $table->integer('Average Score');
            $table->integer('Violation');
            $table->integer('Mistake/Error',);
            $table->integer('Slip/Lapse');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('123_Driver_Behavior_Statistics_table');
    }
};
