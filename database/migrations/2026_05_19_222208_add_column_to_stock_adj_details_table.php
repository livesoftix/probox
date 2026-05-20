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
        Schema::table('stock_adj_details', function (Blueprint $table) {
            $table->string('type')
                  ->default('ADJUSTMENT')
                  ->after('qty');
            $table->date('v_date')->nullable()->after('v_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_adj_details', function (Blueprint $table) {
             $table->dropColumn('v_date');
             $table->dropColumn('type');
        });
    }
};
