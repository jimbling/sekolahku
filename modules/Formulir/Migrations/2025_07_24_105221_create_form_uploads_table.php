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
        Schema::create('form_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('form_responses')->onDelete('cascade'); // respon
            $table->foreignId('question_id')->constrained('form_questions')->onDelete('cascade'); // pertanyaan

            $table->string('file_name');         // nama file asli
            $table->string('file_mime')->nullable(); // tipe MIME (optional)
            $table->string('drive_file_id');     // ID file di Google Drive
            $table->string('drive_file_url');    // URL view/download file dari Google Drive
            $table->integer('file_size')->nullable(); // Ukuran file dalam byte
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_uploads');
    }
};
