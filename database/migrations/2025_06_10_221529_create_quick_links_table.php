<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickLinksTable extends Migration
{
    public function up()
    {
        Schema::create('quick_links', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('url');
            $table->string('icon')->nullable(); // optional: svg name or path
            $table->string('color')->default('blue');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quick_links');
    }
}
