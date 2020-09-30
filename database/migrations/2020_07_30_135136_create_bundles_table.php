<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->string('subtitle')->nullable();
            $table->text('summary')->nullable();
            $table->string('cover', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('slug', 100);
			$table->unsignedTinyInteger('status');
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
        Schema::dropIfExists('bundles');
    }
}
