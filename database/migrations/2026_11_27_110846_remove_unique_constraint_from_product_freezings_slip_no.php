<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_freezings', function (Blueprint $table) {
            $table->dropUnique('product_freezings_slip_no_unique');

            $table->index('slip_no', 'product_freezings_slip_no_index');
        });
    }

    public function down(): void
    {
        Schema::table('product_freezings', function (Blueprint $table) {
            $table->dropIndex('product_freezings_slip_no_index');

            $table->unique('slip_no', 'product_freezings_slip_no_unique');
        });
    }
};