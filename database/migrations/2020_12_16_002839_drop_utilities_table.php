<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUtilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voidSchema::dropIfExists('users');
     */
    public function up()
    {
        Schema::table('utilities', function (Blueprint $table) {
            Schema::dropIfExists('utilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('utilities', function (Blueprint $table) {
            //
        });
    }
}
