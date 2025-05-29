<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('updates', function (Blueprint $table) {


            // Ubah kolom application_id agar tidak nullable
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete()->change();
        });
    }

    public function down()
    {
        Schema::table('updates', function (Blueprint $table) {
            // Ubah kembali menjadi nullable jika rollback
            $table->foreignId('application_id')->nullable()->constrained('applications')->nullOnDelete()->change();
        });
    }
};
