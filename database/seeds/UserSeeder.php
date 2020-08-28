<?php

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
            'avatar' => "https://lorempixel.com/640/480/?10211",
            'slug' => "admin",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
		])->assignRole("admin");
		User::create([
            'first_name' => "Υδρόγειος",
            'last_name' => "Idrogios",
            'avatar' => "https://lorempixel.com/640/480/?10211",
            'email' => "idrogios@gmail.com",
            "phone"=>"6978df65698",
            "profil"=>"Idrogios profil",
            'slug' => "Idrogios",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("admin");
        User::create([
            'first_name' => "instructor",
            'last_name' => "instructor",
            'email' => "instructor@gmail.com",
            "phone"=>"6978562698",
            "profil"=>"instructor profil",
            'avatar' => "https://lorempixel.com/640/480/?10961",
            'slug' => "instructor",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("instructor");
        User::create([
            'first_name' => "partner",
            'last_name' => "partner",
            'email' => "partner@gmail.com",
            "phone"=>"6978564398",
            "profil"=>"admin",
            'avatar' => "https://lorempixel.com/640/480/?10914",
            'slug' => "partner profil",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("partner");
        User::create([
            'first_name' => "student",
            'last_name' => "student",
            'email' => "student@gmail.com",
            "phone"=>"6978523498",
            "profil"=>"student profil",
            'avatar' => "https://lorempixel.com/640/480/?10917",
            'slug' => "student",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("student");


//

//
    }

}
