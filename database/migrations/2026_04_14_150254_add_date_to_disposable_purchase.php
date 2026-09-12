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
        if (!Schema::hasTable('disposable_purchase')) {
            Schema::create('disposable_purchase', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('item_id')->nullable();
                $table->string('qty')->nullable();
                $table->string('weight_type')->nullable();
                $table->string('rate')->nullable();
                $table->string('amount')->nullable();
                $table->string('voucher_no')->nullable();
                $table->string('freight')->nullable();
                $table->string('freight_type')->nullable();
                $table->string('image')->nullable();
                $table->string('v_date')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('disposable_purchase', function (Blueprint $table) {
                if (!Schema::hasColumn('disposable_purchase', 'v_date')) {
                    $table->string('v_date')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposable_purchase', function (Blueprint $table) {
            //
        });
    }
};
