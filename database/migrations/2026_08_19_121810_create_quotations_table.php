<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {

            $table->id();

            $table->string('quotation_no')->unique();

            $table->date('quotation_date');

            // Existing AccountMaster
            // $table->unsignedBigInteger('party_id');
            $table->string('party_name')->nullable();

            $table->text('description')->nullable();

            $table->text('terms_conditions')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();

            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Party Foreign Key
            |--------------------------------------------------------------------------
            */

            // $table->foreign('party_id')
            //     ->references('id')
            //     ->on('account_masters')
            //     ->cascadeOnUpdate()
            //     ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};