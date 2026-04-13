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
        Schema::create('delivery_details', function (Blueprint $table) {
            $table->id();
            $table->string('v_no')->nullable();
            $table->string('sr')->nullable();
            $table->date('po_no')->nullable();
            $table->string('box')->nullable();
            $table->string('pack_qty')->nullable();
            $table->foreignId('item_code')->constrained('item_masters')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_details');
    }
};
