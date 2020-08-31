<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->bigInteger('phone')->nullable();
            $table->text('profil')->nullable();
            $table->string('avatar')->nullable();
            $table->string('facebook_link')->unique()->nullable();
            $table->string('instagram_link')->unique()->nullable();
            $table->string('linkedin_link')->unique()->nullable();
            $table->string('youtube_link')->unique()->nullable();
            $table->string('slug');
            $table->string('password');
            $table->unsignedBigInteger('status');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
