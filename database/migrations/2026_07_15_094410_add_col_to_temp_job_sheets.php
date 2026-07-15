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
        Schema::table('temp_job_sheets', function (Blueprint $table) {
            $table->integer('after_cutting')->nullable()->after('printing_for');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_job_sheets', function (Blueprint $table) {
            $table->dropColumn('after_cutting');
        });
    }
};
