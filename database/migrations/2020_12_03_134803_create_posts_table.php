<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('postable_id');
            $table->string('postable_type', 50);
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string("title");
            $table->string("slug");
            $table->boolean("watched")->default(0);
            $table->boolean("followed")->default(0);
            $table->boolean("closed")->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
