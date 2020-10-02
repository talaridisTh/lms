<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
			$table->foreignId("parent_id")->references('id')
				->on('materials')->onDelete('cascade'); //! einai to material_id
														//! to section stin ousia apo8ikeuete san material
														//! kai ka8e fora pou dimiourgite ena section/material
														//! ginete clone edo!
			$table->foreignId("course_id")->nullable()->references('id')
				->on('courses')->onDelete('cascade');

			$table->string("title");
			$table->string("slug");
			$table->unsignedTinyInteger("status");
			$table->unsignedTinyInteger("priority");
			$table->timestamp('publish_at')->nullable();
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
        Schema::dropIfExists('sections');
    }
}
