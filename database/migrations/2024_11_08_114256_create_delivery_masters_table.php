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
        Schema::create('delivery_masters', function (Blueprint $table) {
            $table->id();
            $table->string('v_no')->nullable();
            $table->string('sr')->nullable();
            $table->date('date')->nullable();
            $table->string('preparedby')->nullable();
            $table->foreignId('account_id')->constrained('account_masters')->onDelete('cascade')->nullable();
            $table->foreignId('delivery_detail_id')->constrained('delivery_detail')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_masters');
    }
};
