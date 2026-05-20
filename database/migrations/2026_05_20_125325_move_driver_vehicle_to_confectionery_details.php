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
        Schema::table('confectionery_details', function (Blueprint $table) {
            $table->string('driver_name')->nullable()->after('freight');
            $table->string('vehicle_number')->nullable()->after('driver_name');
        });

        Schema::table('confectionery_masters', function (Blueprint $table) {
            $table->dropColumn(['driver_name', 'vehicle_number']);
        });
    }

    public function down(): void
    {
        Schema::table('confectionery_masters', function (Blueprint $table) {
            $table->string('driver_name')->nullable();
            $table->string('vehicle_number')->nullable();
        });

        Schema::table('confectionery_details', function (Blueprint $table) {
            $table->dropColumn(['driver_name', 'vehicle_number']);
        });
    }

};
