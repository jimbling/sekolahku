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
        Schema::table('form_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('form_questions', 'file_max_size')) {
                $table->integer('file_max_size')->unsigned()->nullable()->after('is_required');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_file_max_size');
    }
};
