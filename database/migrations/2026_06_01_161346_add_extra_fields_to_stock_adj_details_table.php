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

            // product / reference info
            $table->string('item_code')->nullable()->after('item_id');

            // dimensions (if needed for stock calc)
            $table->decimal('width', 12, 2)->default(0);
            $table->decimal('length', 12, 2)->default(0);
            $table->decimal('grammage', 12, 2)->default(0);

            // quantity & pricing
            $table->decimal('qty', 12, 2)->default(0)->change();
            $table->decimal('rate', 12, 2)->default(0)->change();
            $table->decimal('amount', 12, 2)->default(0)->change();

            // weight & extra charges
            $table->decimal('total_wt', 12, 2)->default(0);
            $table->decimal('freight', 12, 2)->default(0);

            // reference fields
            $table->string('v_no')->change(); // voucher/invoice no
            // $table->date('v_date')->nullable();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_adj_details', function (Blueprint $table) {

            $table->dropColumn([
                'item_code',
                'width',
                'length',
                'grammage',
                'total_wt',
                'freight',
                // 'v_date',
            ]);

            // optional: revert types if needed manually
        });
    }
};
