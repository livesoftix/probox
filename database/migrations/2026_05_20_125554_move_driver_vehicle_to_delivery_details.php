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
        Schema::table('delivery_details', function (Blueprint $table) {
            $table->string('driver_name')->nullable()->after('v_no');
            $table->string('vehicle_number')->nullable()->after('driver_name');
        });

        Schema::table('delivery_masters', function (Blueprint $table) {
            $table->dropColumn(['driver_name', 'vehicle_number']);
        });
    }

    public function down(): void
    {
        Schema::table('delivery_masters', function (Blueprint $table) {
            $table->string('driver_name')->nullable();
            $table->string('vehicle_number')->nullable();
        });

        Schema::table('delivery_details', function (Blueprint $table) {
            $table->dropColumn(['driver_name', 'vehicle_number']);
        });
    }
};
