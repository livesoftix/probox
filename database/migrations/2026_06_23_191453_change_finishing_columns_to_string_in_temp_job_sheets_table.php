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
        Schema::table('temp_job_sheets', function (Blueprint $table) {
            $table->string('lamination')->nullable()->change();
            $table->string('embossing')->nullable()->change();
            $table->string('varnish')->nullable()->change();
            $table->integer('colour')->nullable()->change();
            $table->string('uv')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_job_sheets', function (Blueprint $table) {
            $table->boolean('lamination')->default(false)->change();
            $table->boolean('embossing')->default(false)->change();
            $table->boolean('varnish')->default(false)->change();
            $table->boolean('colour')->default(false)->change();
            $table->boolean('uv')->default(false)->change();
        });
    }
};
