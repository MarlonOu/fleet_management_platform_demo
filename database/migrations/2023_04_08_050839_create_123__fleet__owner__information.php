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
        Schema::create('123__fleet__owner__information', function (Blueprint $table) {
            $table->id();
            $table->integer('Tax_ID');
            $table->char('Company Name', 50);
            $table->char('CEO', 50);
            $table->char('Contact Window', 50);
            $table->char('TEL', 50);
            $table->char('Address', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('123__fleet__owner__information');
    }
};
