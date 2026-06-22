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
       Schema::create('temp_job_sheets', function (Blueprint $table) {
    $table->id();

    $table->string('v_no')->unique();     // 3892
    $table->date('date')->nullable();

    $table->string('job_name')->nullable();

    $table->string('size')->nullable();
    $table->integer('qty')->nullable();

    $table->string('p_size')->nullable();
    $table->string('ream_packet')->nullable();

    $table->boolean('lamination')->default(false);
    $table->boolean('embossing')->default(false);
    $table->boolean('varnish')->default(false);
    $table->boolean('colour')->default(false);
    $table->boolean('uv')->default(false);

    $table->text('note')->nullable();

    $table->date('m_date')->nullable();
    $table->date('e_date')->nullable();

    $table->unsignedBigInteger('created_by');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_job_sheet');
    }
};
