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
        Schema::create('bank_recipts', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('v_type');
            $table->date('date');
            $table->string('bank');
            $table->string('account');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->string('total_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_recipts');
    }
};
