<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->string('prefix')->nullable()->after('alias');
            $table->json('permissions')->nullable()->after('enabled');
            $table->string('author')->nullable()->after('permissions');
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['prefix', 'permissions', 'author']);
        });
    }
};
