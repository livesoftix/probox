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
        Schema::create('journal_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('account_title');
            $table->string('v_type');
            $table->decimal('total_amount', 10, 2);
            $table->text('debit_entries');
            $table->text('credit_entries');
            $table->string('total_debit');
            $table->string('total_credit');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_vouchers');
    }
};
