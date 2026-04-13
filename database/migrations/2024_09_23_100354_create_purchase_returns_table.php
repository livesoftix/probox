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
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->integer('vorcher_no');
            $table->integer('width');
            $table->integer('lenght');
            $table->integer('grammage');
            $table->integer('qty');
            $table->integer('rate');
            $table->integer('total_wt');
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
        Schema::dropIfExists('purchase_returns');
    }
};
