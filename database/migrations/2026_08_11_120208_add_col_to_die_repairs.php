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
        Schema::table('die_repairs', function (Blueprint $table) {
    $table->json('repair_types')
          ->nullable()
          ->after('repair_date');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('die_repairs', function (Blueprint $table) {
            //
        });
    }
};
