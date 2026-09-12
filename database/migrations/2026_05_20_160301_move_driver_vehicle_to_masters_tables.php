<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('delivery_masters')) {
            Schema::table('delivery_masters', function (Blueprint $table) {
                if (!Schema::hasColumn('delivery_masters', 'driver_name')) {
                    $table->string('driver_name')->nullable()->after('preparedby');
                }
                if (!Schema::hasColumn('delivery_masters', 'vehicle_number')) {
                    $table->string('vehicle_number')->nullable()->after('driver_name');
                }
            });
        }

        if (Schema::hasTable('delivery_details')) {
            Schema::table('delivery_details', function (Blueprint $table) {
                $colsToDrop = array_filter(['driver_name', 'vehicle_number'], fn($col) => Schema::hasColumn('delivery_details', $col));
                if (!empty($colsToDrop)) {
                    $table->dropColumn($colsToDrop);
                }
            });
        }

        if (Schema::hasTable('confectionery_masters')) {
            Schema::table('confectionery_masters', function (Blueprint $table) {
                if (!Schema::hasColumn('confectionery_masters', 'driver_name')) {
                    $table->string('driver_name')->nullable()->after('preparedby');
                }
                if (!Schema::hasColumn('confectionery_masters', 'vehicle_number')) {
                    $table->string('vehicle_number')->nullable()->after('driver_name');
                }
            });
        }

        if (Schema::hasTable('confectionery_details')) {
            Schema::table('confectionery_details', function (Blueprint $table) {
                $colsToDrop = array_filter(['driver_name', 'vehicle_number'], fn($col) => Schema::hasColumn('confectionery_details', $col));
                if (!empty($colsToDrop)) {
                    $table->dropColumn($colsToDrop);
                }
            });
        }
    }

    public function down(): void
    {
        /**
         * DELIVERY rollback
         */
        Schema::table('delivery_details', function (Blueprint $table) {
            $table->string('driver_name')->nullable();
            $table->string('vehicle_number')->nullable();
        });

        Schema::table('delivery_masters', function (Blueprint $table) {
            $table->dropColumn(['driver_name', 'vehicle_number']);
        });

        /**
         * CONFECTIONERY rollback
         */
        Schema::table('confectionery_details', function (Blueprint $table) {
            $table->string('driver_name')->nullable();
            $table->string('vehicle_number')->nullable();
        });

        Schema::table('confectionery_masters', function (Blueprint $table) {
            $table->dropColumn(['driver_name', 'vehicle_number']);
        });
    }
};