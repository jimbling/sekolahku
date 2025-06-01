<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThemesTable extends Migration
{
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('theme_name')->unique(); // nama tema, misal 'default', 'darkmode'
            $table->string('display_name')->nullable(); // nama yang tampil di UI, misal 'Tema Default'
            $table->text('description')->nullable(); // deskripsi tema
            $table->boolean('is_active')->default(false); // tema aktif atau tidak
            $table->json('settings')->nullable(); // opsi tema dalam format JSON, bisa untuk warna, font, dsb
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('themes');
    }
}
