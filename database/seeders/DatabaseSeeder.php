<?php

namespace Database\Seeders;

use App\User;
use App\Section;
use App\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Database\Seeders\MessageSeeder;
use Illuminate\Database\Seeder;


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

//        User::create([
//            'first_name' => "darkpony",
//            'last_name' => "darkpony",
//            'email' => "info@darkpony.com",
//            "phone"=>"6978565698",
//            "profil"=>"darkpony",
//            'avatar' => "/images/avatar-placeholder.png",
//            'slug' => "darkpony-super",
//            'password' => Hash::make('darkpony'),
//            "password_encrypt"=>Crypt::encryptString('darkpony'),
//            'status' => 1,
//            'remember_token' => Str::random(10),
//		])->assignRole("super-admin");

		User::create([
            'first_name' => "admin",
            'last_name' => "admin",
            'email' => "admin@gmail.com",
            "phone"=>"6978565698",
            "profil"=>"admin profil",
            'avatar' => "/images/avatar-placeholder.png",
            'slug' => "admin",
            'password' => Hash::make('password'),
            "password_encrypt"=>Crypt::encryptString('password'),
            'status' => 1,
            'remember_token' => Str::random(10),
		])->assignRole("admin");

	}
}
