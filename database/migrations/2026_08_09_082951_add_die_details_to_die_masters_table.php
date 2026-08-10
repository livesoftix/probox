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
        Schema::table('die_masters', function (Blueprint $table) {
                   $table->decimal('rate', 15, 2)
                ->nullable()
                ->after('no_of_ups');

            $table->enum('type', [
                'new',
                'repair',
                'repeat'
            ])
                ->default('new')
                ->after('rate');

            $table->date('repeat_date')
                ->nullable()
                ->after('type');

            $table->unsignedInteger('repair_count')
                ->default(0)
                ->after('repeat_date');

            $table->text('description')
                ->nullable()
                ->after('repair_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('die_masters', function (Blueprint $table) {
           $table->dropColumn([
                'rate',
                'type',
                'repeat_date',
                'repair_count',
                'description',
            ]);
        });
    }
};
