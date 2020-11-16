<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_material', function (Blueprint $table) {
			$table->id();
			$table->foreignId('course_id')->references('id')->on('courses')->onDelete('cascade');
			$table->foreignId('material_id')->references('id')->on('materials')->onDelete('cascade');
			$table->unsignedSmallInteger('status')->default(0);
			$table->unsignedSmallInteger('guest_status')->default(0);
			$table->unsignedSmallInteger('priority');
			// $table->unsignedSmallInteger('highlight')->default(0); // added later
			$table->timestamp('publish_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_material');
    }
}
