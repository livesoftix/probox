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
           $table->string('printing_for')->nullable()->after('preparedby');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_job_sheets', function (Blueprint $table) {
            $table->dropColumn('printing_for');
        });
    }
};
