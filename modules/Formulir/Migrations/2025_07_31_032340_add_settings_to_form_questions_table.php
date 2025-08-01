<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 🔹 1. Ubah ENUM kolom 'type' untuk menambahkan time & datetime
        DB::statement("ALTER TABLE form_questions MODIFY COLUMN type ENUM('text', 'textarea', 'select', 'radio', 'checkbox', 'date', 'time', 'datetime', 'file')");

        // 🔹 2. Tambahkan kolom JSON settings
        Schema::table('form_questions', function (Blueprint $table) {
            $table->json('settings')->nullable()->after('sort_order');
        });
    }

    public function down(): void
    {
        // ⚠️ Balikin ENUM ke versi awal (tanpa time & datetime)
        DB::statement("ALTER TABLE form_questions MODIFY COLUMN type ENUM('text', 'textarea', 'select', 'radio', 'checkbox', 'date', 'file')");

        // Hapus kolom settings
        Schema::table('form_questions', function (Blueprint $table) {
            $table->dropColumn('settings');
        });
    }
};
