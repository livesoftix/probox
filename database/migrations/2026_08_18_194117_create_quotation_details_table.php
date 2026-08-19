<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation_details', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('quotation_id');

            // Existing ItemMaster
            // $table->unsignedBigInteger('item_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Snapshot fields
            |--------------------------------------------------------------------------
            | These preserve what was actually quoted.
            */

            $table->string('item_name');

            $table->text('item_details')->nullable();

            $table->decimal('qty', 12, 4)->nullable();

            $table->decimal('rate', 15, 2);

            $table->decimal('amount', 15, 2)->nullable();

            $table->integer('sort_order')->default(1);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Quotation
            |--------------------------------------------------------------------------
            */

            $table->foreign('quotation_id')
                ->references('id')
                ->on('quotations')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Item
            |--------------------------------------------------------------------------
            */

            // $table->foreign('item_id')
            //     ->references('id')
            //     ->on('item_masters')
            //     ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_details');
    }
};