<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackupsTable extends Migration
{
    public function up()
    {
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->unique(); // Nama file backup
            $table->string('path'); // Lokasi file di disk
            $table->integer('size'); // Ukuran file dalam bytes
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('backups');
    }
}
