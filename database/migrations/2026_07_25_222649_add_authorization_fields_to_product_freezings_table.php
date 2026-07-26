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
        Schema::table('product_freezings', function (Blueprint $table) {

            $table->string('prepared_by')->nullable()->after('description');

            $table->string('production_by')->nullable()->after('prepared_by');

        });
    }

    public function down(): void
    {
        Schema::table('product_freezings', function (Blueprint $table) {

            $table->dropColumn([
                'prepared_by',
                'production_by'
            ]);

        });
    }
};
