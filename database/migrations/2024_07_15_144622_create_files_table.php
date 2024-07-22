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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('file_title');
            $table->text('file_description')->nullable();
            $table->string('file_name');
            $table->string('file_type');
            $table->unsignedBigInteger('file_category_id')->nullable();
            $table->foreign('file_category_id')->references('id')->on('categories')->onDelete('set null');
            $table->string('file_path');
            $table->string('file_ext');
            $table->unsignedBigInteger('file_size');
            $table->unsignedInteger('file_counter')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
