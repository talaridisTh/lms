<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id')->references('id')->on('users')->onDelete("cascade");
			$table->string("subject");
			$table->longText("content");
			$table->json("recipients")->nullable();
			$table->unsignedTinyInteger("status"); //! 0 draft - 1 sent
			$table->timestamp("sent_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mails');
    }
}
