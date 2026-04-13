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
        Schema::create('glue_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('vorcher_no');
            $table->integer('qty');
            $table->integer('rate');
            $table->integer('amount');
            $table->foreignId('item_code')->constrained('item_masters')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glue_purchases');
    }
};
