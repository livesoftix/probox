<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('product_master', function (Blueprint $table) {
            $table->dropColumn('job_assign');
        });

        Schema::table('product_master', function (Blueprint $table) {
            $table->unsignedBigInteger('job_assign')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('product_master', function (Blueprint $table) {
            $table->dropColumn('job_assign');
        });

        Schema::table('product_master', function (Blueprint $table) {
            $table->string('job_assign')->nullable();
        });
    }
};
