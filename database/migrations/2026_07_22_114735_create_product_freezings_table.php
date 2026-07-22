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
        Schema::create('product_freezings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('slip_no')->unique();
            $table->foreignId('product_id')->constrained('product_master');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_freezings');
    }
};
