<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            $table->string('po_code')->unique();

            $table->string('party_name');
            $table->text('party_address')->nullable();

            $table->date('po_date');
            $table->date('delivery_date')->nullable();

            $table->string('assign_to')->nullable();

            // Automatically filled from authenticated user
            $table->unsignedBigInteger('prepared_by')->nullable();

            $table->string('print_by')->nullable();

            $table->string('machine_size');

            $table->unsignedInteger('total_quantity')->default(0);

            $table->timestamps();

            $table->foreign('prepared_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};