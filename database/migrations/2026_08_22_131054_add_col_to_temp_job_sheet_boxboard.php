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
        Schema::table('temp_job_sheet_boxboard', function (Blueprint $table) {
            $table->float('grammage')->after('length')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_job_sheet_boxboard', function (Blueprint $table) {
            $table->dropColumn('grammage');
        });
    }
};
