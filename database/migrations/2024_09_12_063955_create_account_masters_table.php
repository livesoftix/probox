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
        Schema::create('account_masters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('opening_date');
            $table->string('account_code');
            $table->foreignId('level2_id')->constrained('level2s')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_masters');
    }
};
