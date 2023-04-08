<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::rename('123_fleet_owner_information', '123_fleet_owner_information_table');
    }

    public function down(): void
    {
        Schema::rename('123_fleet_owner_information_table', '123_fleet_owner_information');
    }
};
