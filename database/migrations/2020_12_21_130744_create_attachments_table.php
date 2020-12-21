<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('original_name', 255)->nullable()->index();
            $table->string('name')->nullable()->index(); // slug clean name, with possible increments if duplicate exists
            $table->tinyInteger('type')->default(0); // image, file, video , comment-image, task, etc, 9 => ad
            $table->tinyInteger('course_id')->nullable();
            $table->tinyInteger('mail_id')->nullable();

            $table->text('rel_path')->nullable(); // the directories form the data root to the file. Could use to allow custom folder creation and uploads to them. this is a tree branch, needs more thought

            $table->string('ext', 10)->nullable(); // the extensions of the media
            $table->string('file_info')->nullable(); // the mime / file info, think about cases of videos
            $table->unsignedMediumInteger('size')->nullable();



            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
