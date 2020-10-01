<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_section', function (Blueprint $table) {
            $table->id();
			$table->foreignId('section_id')->references('id')->on('sections')->onDelete('cascade');
			$table->foreignId('material_id')->references('id')->on('materials')->onDelete('cascade');
			$table->unsignedTinyInteger('status')->default(0);
			$table->unsignedTinyInteger('priority');
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
        Schema::dropIfExists('material_section');
    }
}
