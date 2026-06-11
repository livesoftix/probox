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
        Schema::table('confect_billings', function (Blueprint $table) {
            $table->date('v_date')->nullable()->after('v_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('confect_billings', function (Blueprint $table) {
            $table->dropColumn('v_date');
        });
    }
};
