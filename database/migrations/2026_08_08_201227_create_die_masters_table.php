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
        Schema::create('die_masters', function (Blueprint $table) {
            $table->id();
             $table->foreignId('product_id')
                ->constrained('product_master')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Snapshot values from ProductMaster
            // This protects historical die records if product data changes later.
            $table->string('item_name');
            $table->decimal('length', 12, 3)->nullable();
            $table->decimal('width', 12, 3)->nullable();
            $table->unsignedInteger('no_of_ups')->nullable();

            $table->timestamps();

            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('die_masters');
    }
};
