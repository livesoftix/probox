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
        Schema::table('general_delivery_challens', function (Blueprint $table) {
             $table->string('driver_name')->nullable()->after('party_name');
            $table->string('vehicle_number')->nullable()->after('driver_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_delivery_challens', function (Blueprint $table) {
            $table->dropColumn(['driver_name', 'vehicle_number']);
        });
    }
};
