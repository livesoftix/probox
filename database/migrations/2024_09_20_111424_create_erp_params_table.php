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
        Schema::create('erp_params', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_level')->constrained('level2s')->onDelete('cascade')->nullable();
            $table->foreignId('bank_level')->constrained('level2s')->onDelete('cascade')->nullable();
            $table->foreignId('supplier_level')->constrained('level2s')->onDelete('cascade')->nullable();
            $table->foreignId('purchase_account')->constrained('account_masters')->onDelete('cascade')->nullable();
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_params');
    }
};
