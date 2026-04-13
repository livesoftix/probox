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
        Schema::create('t_r_n_d_t_l_s', function (Blueprint $table) {
            $table->id();
            $table->string('v_no')->nullable();
            $table->string('v_type')->nullable();
            $table->date('date')->nullable();
            $table->string('cash')->nullable();
            $table->string('account')->nullable();
            $table->string('description')->nullable();
            $table->string('debit')->nullable();
            $table->string('credit')->nullable();
            $table->string('status')->nullable();
            $table->string('preparedby')->nullable();
            $table->foreignId('cash_id')->constrained('account_masters')->onDelete('cascade')->nullable();
            $table->foreignId('account_id')->constrained('account_masters')->onDelete('cascade')->nullable();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade')->nullable();
            $table->foreignId('purchase_detail_id')->constrained('purchase_details')->onDelete('cascade')->nullable();
            $table->foreignId('purchase_return_id')->constrained('purchase_returns')->onDelete('cascade')->nullable();
            $table->foreignId('purchase_plate_id')->constrained('purchase_plates')->onDelete('cascade')->nullable();
            $table->foreignId('glue_purchase_id')->constrained('glue_purchases')->onDelete('cascade')->nullable();
            $table->foreignId('lamination_purchase_id')->constrained('lamination_purchases')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_r_n_d_t_l_s');
    }
};
