<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
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
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email')->unique();
            $table->bigInteger('phone');
            $table->text('profil');
            $table->string('avatar');
            $table->string('facebook_link')->unique()->nullable();
            $table->string('instagram_link')->unique()->nullable();
            $table->string('linkedin_link')->unique()->nullable();
            $table->string('youtube_link')->unique()->nullable();
            $table->string('slug');
            $table->text('password');
            $table->text('password_encrypt')->nullable();
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
