<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->string('slug');
            $table->string('subtitle')->nullable();
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
			$table->text('content')->nullable();
			$table->longText("script")->nullable();
            $table->string('cover')->nullable();
            $table->text('video_link')->nullable();
            $table->text('link')->nullable();
            $table->unsignedTinyInteger('status');
			$table->string('type', 20);
			$table->json('fields')->nullable();
            $table->timestamps();
//            soft-delete
//            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');

    }
}
