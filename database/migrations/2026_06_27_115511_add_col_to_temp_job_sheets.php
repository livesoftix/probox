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
            $table->tinyInteger('lamination')->nullable();
            $table->tinyInteger('corrugation')->nullable();
            $table->tinyInteger('color')->nullable();
            $table->integer('color_no')->nullable();
            $table->tinyInteger('window')->nullable();
            $table->tinyInteger('glass_win')->nullable();
            $table->tinyInteger('uv')->nullable();
            $table->tinyInteger('varnish')->nullable();
            $table->float('lam_size')->nullable();
            $table->integer('lam_item')->nullable();
            $table->float('curr_size')->nullable();
            $table->integer('curr_item')->nullable();
            $table->integer('emboss')->nullable();
             $table->integer('breaking')->nullable();
             
              $table->tinyInteger('simple')->nullable();
            $table->tinyInteger('spot')->nullable();
            $table->tinyInteger('tripof')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_job_sheets', function (Blueprint $table) {
            //
        });
    }
};
