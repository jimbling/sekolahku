<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysOnAnggotaRombels extends Migration
{
    public function up(): void
    {
        Schema::table('anggota_rombels', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['rombel_id']);
            $table->dropForeign(['student_id']);

            // Add new foreign keys without cascade
            $table->foreign('rombel_id')->references('id')->on('rombongan_belajars')->onDelete('restrict');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('anggota_rombels', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['rombel_id']);
            $table->dropForeign(['student_id']);

            // Re-add foreign keys with cascade
            $table->foreign('rombel_id')->references('id')->on('rombongan_belajars')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }
}
