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
        Schema::table('students', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('is_alumni'); // Jika alamat panjang
            $table->string('no_hp')->nullable()->after('alamat'); // Nomor telepon
            $table->year('tahun_lulus')->nullable()->after('no_hp'); // Tahun lulus sebagai tahun
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('alamat');
            $table->dropColumn('no_hp');
            $table->dropColumn('tahun_lulus');
        });
    }
};
