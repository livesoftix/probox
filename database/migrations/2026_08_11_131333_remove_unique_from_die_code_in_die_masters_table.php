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
        Schema::table('die_masters', function (Blueprint $table) {
            $table->dropUnique(['die_code']);
        });
    }

    public function down(): void
    {
        Schema::table('die_masters', function (Blueprint $table) {
            $table->unique('die_code');
        });
    }
};
