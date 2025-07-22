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
        Schema::table('files', function (Blueprint $table) {
            $table->string('file_name')->nullable()->change();
            $table->string('file_type')->nullable()->change();
            $table->string('file_path')->nullable()->change();
            $table->string('file_ext')->nullable()->change();
            $table->unsignedBigInteger('file_size')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->string('file_name')->nullable(false)->change();
            $table->string('file_type')->nullable(false)->change();
            $table->string('file_path')->nullable(false)->change();
            $table->string('file_ext')->nullable(false)->change();
            $table->unsignedBigInteger('file_size')->nullable(false)->change();
        });
    }
};
