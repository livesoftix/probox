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
    Schema::create('temp_job_sheet_boxboard', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('job_sheet_id');
        $table->unsignedBigInteger('item_id');

        // ✅ NEW FIELDS
        $table->float('length')->nullable();
        $table->float('width')->nullable();

        $table->float('qty')->default(0);

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_job_sheet_boxboard');
    }
};
