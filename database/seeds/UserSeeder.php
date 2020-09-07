<?php

use App\Course;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
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
            'avatar' => "6176c9b44bf3aa29b77b8d335ec4d38d.jpg",
            'slug' => "admin",
            'password' => Hash::make('password'),
            'status' => 1,
            'remember_token' => Str::random(10),
		])->assignRole("admin");
		User::create([
            'first_name' => "Υδρόγειος",
            'last_name' => "Idrogios",
            'avatar' => "6176c9b44bf3aa29b77b8d335ec4d38d.jpg",
            'email' => "idrogios@gmail.com",
            "phone"=>"6978512598",
            "profil"=>"Idrogios profil",
            'slug' => "Idrogios",
            'password' => Hash::make('password'),
            'status' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("instructor");
        User::create([
            'first_name' => "instructor",
            'last_name' => "instructor",
            'email' => "instructor@gmail.com",
            "phone"=>"6978562698",
            "profil"=>"instructor profil",
            'avatar' => "6176c9b44bf3aa29b77b8d335ec4d38d.jpg",
            'slug' => "instructor",
            'password' => Hash::make('password'),
            'status' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("instructor");
        User::create([
            'first_name' => "partner",
            'last_name' => "partner",
            'email' => "partner@gmail.com",
            "phone"=>"6978564398",
            "profil"=>"admin",
            'avatar' => "6176c9b44bf3aa29b77b8d335ec4d38d.jpg",
            'slug' => "partner profil",
            'password' => Hash::make('password'),
            'status' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("partner");
        User::create([
            'first_name' => "student",
            'last_name' => "student",
            'email' => "student@gmail.com",
            "phone"=>"6978523498",
            "profil"=>"student profil",
            'avatar' => "6176c9b44bf3aa29b77b8d335ec4d38d.jpg",
            'slug' => "student",
            'password' => Hash::make('password'),
            'status' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("student");






//

//
    }

}
