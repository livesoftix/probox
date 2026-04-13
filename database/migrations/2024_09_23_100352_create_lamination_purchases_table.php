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
        Schema::create('lamination_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('vorcher_no');
            $table->integer('size');
            $table->integer('qty');
            $table->integer('rate');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamination_purchases');
    }
};
