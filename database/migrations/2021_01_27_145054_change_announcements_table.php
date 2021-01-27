<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAnnouncementsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropForeign('announcements_user_id_foreign');
            $table->dropColumn("user_id");
        });
        Schema::table('announcements', function (Blueprint $table) {

            $table->integer('user_id')->after("id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
