<?php

// database/migrations/xxxx_xx_xx_create_widgets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // nama file blade (tanpa .blade.php)
            $table->string('title');             // judul tampil
            $table->enum('type', ['sidebar', 'footer'])->default('sidebar');
            $table->boolean('is_active')->default(true);
            $table->integer('position')->default(0);
            $table->json('settings')->nullable(); // pengaturan tambahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
