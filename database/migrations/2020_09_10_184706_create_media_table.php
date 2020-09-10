<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
			$table->bigIncrements('id')->unsigned();
            $table->string('original_name', 255)->nullable()->index();
            $table->string('name')->nullable()->index(); // slug clean name, with possible increments if duplicate exists
            $table->tinyInteger('type')->default(0); // image, file, video etc, 9 => ad
            $table->tinyInteger('usability')->default(0); // 0 : all, 1 : admins

            $table->integer('path')->nullable(); // depends if we want to keep emporium data structuring
            $table->text('rel_path')->nullable(); // the directories form the data root to the file. Could use to allow custom folder creation and uploads to them. this is a tree branch, needs more thought

            $table->string('ext', 10)->nullable(); // the extensions of the media
            $table->string('file_info', 40)->nullable(); // the mime / file info, think about cases of videos
            $table->decimal('size', 12, 4)->nullable();

            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->integer('dpi')->nullable(); // get this using imagemagick: Imagick::getImageResolution

            $table->string('video_id', 80)->nullable();
            $table->string('video_url', 255)->nullable();
            $table->string('video_provider', 40)->nullable(); // youtube, vimeo, daily motion. usable for loading different players for each video etc

            $table->text('details')->nullable(); // a json object with misc. details about this media. usable on videos and oembed results

            $table->nullableTimestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
