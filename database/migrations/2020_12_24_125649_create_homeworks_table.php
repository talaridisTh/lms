<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homeworks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->references('id')->on('users')->onDelete("cascade");
            $table->unsignedBigInteger('instructor_id')->references('id')->on('users')->onDelete("cascade");
            $table->integer('course_id')->nullable();
            $table->string("subject");
            $table->longText("content")->nullable( );
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
        Schema::dropIfExists('homeworks');
    }
}
