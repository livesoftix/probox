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
        Schema::table('stock_adj_masters', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable()->after('cid');

            $table->string('product_type')->nullable()->after('item_id');
            $table->string('item_name')->nullable()->after('product_type');
            $table->decimal('length', 10, 2)->nullable()->after('item_name');
            $table->decimal('width', 10, 2)->nullable()->after('length');
            $table->string('product_name')->nullable()->after('width');
            $table->string('country_name')->nullable()->after('product_name');
            $table->string('size')->nullable()->after('country_name');
            $table->decimal('qty', 15, 2)->nullable()->after('size');
            $table->text('description')->nullable()->after('qty');

            // Optional Foreign Key
            // $table->foreign('item_id')
            //       ->references('id')
            //       ->on('items')
            //       ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_adj_masters', function (Blueprint $table) {

            // Uncomment if foreign key is added
            // $table->dropForeign(['item_id']);

            $table->dropColumn([
                'item_id',
                'product_type',
                'item_name',
                'length',
                'width',
                'product_name',
                'country_name',
                'size',
                'qty',
                'description',
            ]);
        });
    }
};