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
            'avatar' => "https://lorempixel.com/640/480/?10211",
            'email' => "admin@gmail.com",
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
            'slug' => "Idrogios",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("admin");
        User::create([
            'first_name' => "instructor",
            'last_name' => "instructor",
            'avatar' => "https://lorempixel.com/640/480/?10961",
            'email' => "instructor@gmail.com",
            'slug' => "instructor",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("instructor");
        User::create([
            'first_name' => "partner",
            'last_name' => "partner",
            'avatar' => "https://lorempixel.com/640/480/?10914",
            'email' => "partner@gmail.com",
            'slug' => "partner",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("partner");
        User::create([
            'first_name' => "student",
            'last_name' => "student",
            'avatar' => "https://lorempixel.com/640/480/?10917",
            'email' => "student@gmail.com",
            'slug' => "student",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("student");


//

//
    }

}
