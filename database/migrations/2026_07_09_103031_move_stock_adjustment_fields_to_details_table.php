<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_adj_details', function (Blueprint $table) {

            $table->string('product_type')->nullable()->after('item_id');
            $table->string('item_name')->nullable()->after('product_type');

            $table->enum('adjustment_type', ['IN', 'OUT'])
                  ->default('OUT')
                  ->after('qty');

            $table->text('description')->nullable()->after('adjustment_type');

            // These already exist in your table:
            // length
            // width

            $table->string('product_name')->nullable()->after('description');
            $table->string('country_name')->nullable()->after('product_name');
            $table->decimal('size',10,2)->nullable()->after('country_name');
        });

        Schema::table('stock_adj_masters', function (Blueprint $table) {

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
                'description'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('stock_adj_masters', function (Blueprint $table) {

            $table->unsignedBigInteger('item_id')->nullable();

            $table->string('product_type')->nullable();
            $table->string('item_name')->nullable();

            $table->decimal('length',10,2)->nullable();
            $table->decimal('width',10,2)->nullable();

            $table->string('product_name')->nullable();
            $table->string('country_name')->nullable();

            $table->decimal('size',10,2)->nullable();

            $table->decimal('qty',12,2)->default(0);

            $table->text('description')->nullable();
        });

        Schema::table('stock_adj_details', function (Blueprint $table) {

            $table->dropColumn([
                'product_type',
                'item_name',
                'adjustment_type',
                'description',
                'product_name',
                'country_name',
                'size',
            ]);
        });
    }
};