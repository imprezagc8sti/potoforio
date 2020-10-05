<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('microposts', function (Blueprint $table) {
            $table->string('stars');
        });
    }

    public function down()
    {
        Schema::table('microposts', function (Blueprint $table) {
            $table->dropColumn('stars');
        });
    }
}