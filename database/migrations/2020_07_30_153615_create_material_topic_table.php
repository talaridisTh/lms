<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_topic', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->foreignId('topic_id')->references('id')->on('topic')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_topic');
    }
}
