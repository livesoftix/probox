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
        Schema::create('dyes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('party_name');
            $table->string('rate')->nullable();
            $table->string('gate_pass_in')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dyes');
    }
};
