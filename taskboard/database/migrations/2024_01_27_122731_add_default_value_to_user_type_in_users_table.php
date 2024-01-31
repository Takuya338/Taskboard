<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToUserTypeInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('userType')->default(0)->change();
            $table->string('userStatus')->default(1)->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('userType')->default(null)->change();
            $table->string('userStatus')->default(null)->change();
        });
    }
}
