<?php

// database/migrations/xxxx_xx_xx_add_userable_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserableToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->nullableMorphs('userable'); // akan menambahkan userable_id & userable_type
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropMorphs('userable');
        });
    }
}
