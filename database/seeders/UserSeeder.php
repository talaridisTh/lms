<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


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

		User::create([
			'first_name' => "Υδρόγειος",
			'last_name' => "Idrogios",
			'avatar' => "/images/avatar-placeholder.png",
			'email' => "idrogios@gmail.com",
			"phone"=>"6978512598",
			"profil"=>" Lorem ipsum dolor sit amet, consectetur adipiscing elit.Integer dignissim odio sit amet magna sagittis, quis sagittis ex convallis. Pellentesque suscipit, neque vitae finibus pretium. ",
			'slug' => "Idrogios",
			'password' => Hash::make('password'),
			"password_encrypt"=>Crypt::encryptString('password'),
			'status' => 1,
			'remember_token' => Str::random(10),
		])->assignRole("instructor");
		User::create([
			'first_name' => "instructor",
			'last_name' => "instructor",
			'email' => "instructor@gmail.com",
			"phone"=>"6978562698",
			"profil"=>"instructor profil",
			'avatar' => "/images/avatar-placeholder.png",
			'slug' => "instructor",
			'password' => Hash::make('password'),
			"password_encrypt"=>Crypt::encryptString('password'),
			'status' => 1,
			'remember_token' => Str::random(10),
		])->assignRole("instructor");
		User::create([
			'first_name' => "partner",
			'last_name' => "partner",
			'email' => "partner@gmail.com",
			"phone"=>"6978564398",
			"profil"=>"admin",
			'avatar' => "/images/avatar-placeholder.png",
			'slug' => "partner profil",
			'password' => Hash::make('password'),
			"password_encrypt"=>Crypt::encryptString('password'),
			'status' => 1,
			'remember_token' => Str::random(10),
		])->assignRole("partner");

		User::create([
			'first_name' => "student",
			'last_name' => "student",
			'email' => "student@gmail.com",
			"phone"=>"6978523498",
			"profil"=>"student profil",
			'avatar' => "/images/avatar-placeholder.png",
			'slug' => "student",
			'password' => Hash::make('password'),
			"password_encrypt"=>Crypt::encryptString('password'),
			'status' => 1,
			'remember_token' => Str::random(10),
		])->assignRole("student");
		User::create([
			'first_name' => "trial user",
			'last_name' => "trial user",
			'email' => "trial-user@gmail.com",
			"phone"=>"6928523498",
			"profil"=>"trial user",
			'avatar' => "/images/avatar-placeholder.png",
			'slug' => "trial-user",
			'password' => Hash::make('password'),
			"password_encrypt"=>Crypt::encryptString('password'),
			'status' => 1,
			'remember_token' => Str::random(10),
		])->assignRole("trial user");


        User::create([
            'first_name' => "Darkpony",
            'last_name' => "Digital",
            'email' => "info@darkpony.com",
            "phone"=>"6978565698",
            "profil"=>"darkpony",
            'avatar' => "/images/avatar-placeholder.png",
            'slug' => "darkpony-super",
            'password' => Hash::make('darkpony'),
            "password_encrypt"=>Crypt::encryptString('darkpony'),
            'status' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("super-admin");

	}
}
