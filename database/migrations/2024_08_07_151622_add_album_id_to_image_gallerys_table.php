<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlbumIdToImageGallerysTable extends Migration
{
    public function up()
    {
        Schema::table('image_gallerys', function (Blueprint $table) {
            $table->foreignId('album_id')->constrained('albums')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('image_gallerys', function (Blueprint $table) {
            $table->dropForeign(['album_id']);
            $table->dropColumn('album_id');
        });
    }
}
