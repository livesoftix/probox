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
        Schema::create('corrugation_rolls', function (Blueprint $table) {
            $table->id();
            $table->string('party_name');
            $table->string('size')->nullable();
            $table->string('rate')->nullable();
            $table->string('no_of_roles')->nullable();
            $table->string('gate_pass_in')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corrugation_rolls');
    }
};
