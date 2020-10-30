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
            $table->string('name', 50)->nullable(); // na min svisti xriazete gia to message system
            $table->string('last_name', 50);
            $table->string('email')->unique();
            $table->string('avatar')->default(config('chatify.user_avatar.default'))->nullable();
            $table->string('messenger_color')->default('#2180f3');
            $table->boolean('dark_mode')->default(0);
            $table->boolean('active_status')->default(0);
            $table->text('phone');
            $table->text('profil')->nullable();
            $table->string('facebook_link')->unique()->nullable();
            $table->string('instagram_link')->unique()->nullable();
            $table->string('linkedin_link')->unique()->nullable();
            $table->string('youtube_link')->unique()->nullable();
            $table->string('slug')->nullable();
            $table->text('password');
            $table->text('password_encrypt')->nullable();
            $table->unsignedBigInteger('status')->nullable();
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
