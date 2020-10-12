<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilities', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("first_section")->nullable();
            $table->text("second_section")->nullable();
            $table->text("third_section")->nullable();
            $table->text("fourth_section")->nullable();
			$table->text("fifth_section")->nullable();
			$table->json("sixth_section")->nullable();
            $table->json("seventh_section")->nullable();
            $table->json("eighth_section")->nullable();
            $table->json("statuses")->nullable();
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
        Schema::dropIfExists('utilities');
    }
}
