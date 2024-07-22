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
        Schema::create('rombongan_belajars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_years_id');
            $table->unsignedBigInteger('classroom_id');
            $table->unsignedBigInteger('gtks_id');
            $table->timestamps();

            $table->foreign('academic_years_id')->references('id')->on('academic_years')->onDelete('restrict');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('restrict');
            $table->foreign('gtks_id')->references('id')->on('gtks')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rombongan_belajar');
    }
};
