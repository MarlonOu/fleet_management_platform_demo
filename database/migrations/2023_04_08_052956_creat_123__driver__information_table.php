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
        Schema::create('123_Driver_Information_table', function (Blueprint $table) {
            $table->id();
            $table->integer('Employ_ID');
            $table->char('Driver_Name', 50);
            $table->char('Sex', 50);
            $table->date('Birthday');
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
        Schema::dropIfExists('123_Driver_Information_table');
    }
};
