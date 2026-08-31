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
        Schema::table('product_master', function (Blueprint $table) {
            $table->tinyInteger('manual_pasting')->default(0)->before('manual_pasting_rate');
            $table->tinyInteger('auto_pasting')->default(0)->before('auto_pasting_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_master', function (Blueprint $table) {
            $table->dropColumn(['maunal_pasting','auto_pasting']);
        });
    }
};
