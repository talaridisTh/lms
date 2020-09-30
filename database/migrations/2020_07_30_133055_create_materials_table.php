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
            $table->string('cover')->nullable();
            $table->text('description')->nullable();
            $table->text('video_link')->nullable();
            $table->text('content')->nullable();
            $table->text('gallery')->nullable();
            $table->text('file')->nullable();
            $table->unsignedTinyInteger('status');
            $table->string('type', 20);
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
