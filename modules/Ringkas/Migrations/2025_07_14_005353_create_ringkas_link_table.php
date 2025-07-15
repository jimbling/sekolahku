<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ringkas_links', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->text('original_url');
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('hit_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); // opsional
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ringkas_links');
    }
};
