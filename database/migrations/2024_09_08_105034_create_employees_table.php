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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->string('address')->nullable();
            $table->string('blood_group')->nullable();
            $table->decimal('salary', 8, 2)->nullable();
            $table->string('shift_time1')->nullable();
            $table->string('shift_time2')->nullable();
            $table->enum('registered', ['official', 'unofficial'])->default('official');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
