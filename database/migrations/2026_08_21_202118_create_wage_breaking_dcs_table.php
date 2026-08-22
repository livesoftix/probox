<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wage_breaking_dcs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('b_no');
            $table->string('v_no');

            $table->date('dc_date')->nullable();

            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('prod_id')->nullable();

            $table->string('product_name')->nullable();

            $table->decimal('qty', 15, 2)->default(0);
            $table->decimal('clabour', 15, 4)->default(0);
            $table->decimal('breaking_wage', 15, 2)->default(0);

            $table->decimal('previous_loan', 15, 2)->default(0);
            $table->decimal('deduction', 15, 2)->default(0);
            $table->decimal('other_exp', 12, 2)->default(0);

            $table->string('description')->nullable();

            $table->decimal('remaining_loan', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);

            $table->string('dc_type')->nullable();

            $table->date('date');

            $table->string('prepared_by')->nullable();

            $table->string('v_type')->default('Salary');

            $table->timestamps();

            $table->string('batch_no')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wage_breaking_dcs');
    }
};