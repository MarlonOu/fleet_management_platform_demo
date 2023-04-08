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
        Schema::create('123_fleet_owner_information', function (Blueprint $table) {
            $table->id();
            $table->integer('tax_id');
            $table->char('company name', 50);
            $table->char('ceo', 50);
            $table->char('contact window', 50);
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
        Schema::dropIfExists('123_fleet_owner_information');
    }
};
