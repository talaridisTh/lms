<?php

namespace Database\Seeders;

use App\Course;
use App\User;
use App\Material;
use App\Role;
use App\Topic;
use App\Bundle;
use App\Section;
use App\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Database\Seeders\MessageSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $this->call([
            RoleSeeder::class,
		]);
		
		Utility::factory()->create();

		User::create([
            'first_name' => "admin",
            'last_name' => "admin",
            'email' => "admin@gmail.com",
            "phone" => "6978565698",
            "profil" => "admin profil",
            'avatar' => "/images/avatar-placeholder.png",
            'slug' => "admin",
            'password' => Hash::make('password'),
            "password_encrypt" => Crypt::encryptString('password'),
            'status' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("admin");
	}
}
