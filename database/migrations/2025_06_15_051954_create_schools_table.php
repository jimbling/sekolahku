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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->uuid('school_uuid')->unique();
            $table->string('name');
            $table->string('npsn')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('license_key')->nullable();
            $table->enum('license_status', ['inactive', 'active', 'expired'])->default('inactive');
            $table->date('valid_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
