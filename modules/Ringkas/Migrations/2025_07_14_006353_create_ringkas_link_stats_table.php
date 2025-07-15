<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ringkas_link_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained('ringkas_links')->cascadeOnDelete();
            $table->string('ip_address', 45);
            $table->text('user_agent');
            $table->text('referer')->nullable();
            $table->string('country')->nullable();
            $table->timestamp('clicked_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ringkas_link_stats');
    }
};
