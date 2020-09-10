<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_details', function (Blueprint $table) {
            $table	->id();
			$table	->foreignId('media_id')
					->references('id')->on('media')->onDelete('cascade');

			$table	->string('title', 255)->nullable()->index();
			$table	->string('subtitle', 255)->nullable();
			$table	->string('caption', 255)->nullable();
			$table	->text('description')->nullable();

            $table	->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_details');
    }
}
