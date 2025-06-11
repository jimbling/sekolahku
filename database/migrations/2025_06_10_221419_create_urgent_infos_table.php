<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrgentInfosTable extends Migration
{
    public function up()
    {
        Schema::create('urgent_infos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('urgent_infos');
    }
}
