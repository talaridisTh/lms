<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->string('subtitle')->nullable();
            $table->text('summary')->nullable();
            $table->string('cover')->nullable();
			$table->text('description')->nullable();
			$table->longText("script")->nullable();
            $table->unsignedBigInteger('user_id')->references('id')->on('users')->nullable();
            $table->string('slug');
            $table->string('version');
			$table->unsignedTinyInteger('status');
			$table->string("template")->default("index.courses.template-1.courseProfile"); //added later
			$table->json('fields')->nullable();
			$table->timestamp('publish_at')->nullable();
			$table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
