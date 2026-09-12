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
        if (Schema::hasTable('packaging_specs')) {
            Schema::table('packaging_specs', function (Blueprint $table) {
                if (!Schema::hasColumn('packaging_specs', 'uv_size')) {
                    $table->string('uv_size')->nullable();
                }
                if (!Schema::hasColumn('packaging_specs', 'varnish')) {
                    $table->tinyInteger('varnish')->default(0);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packaging_specs', function (Blueprint $table) {
            //
        });
    }
};
