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
            'avatar' => "sjkfbhdjka0dbd541fbe1ca1a045e.jpg",
            'email' => "admin@gmail.com",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("admin");
        User::create([
            'first_name' => "instructor",
            'last_name' => "instructor",
            'avatar' => "fjmwedkskb0880dbd541fbe1ca1a045e.jpg",
            'email' => "instructor@gmail.com",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("instructor");
        User::create([
            'first_name' => "partner",
            'last_name' => "partner",
            'avatar' => "fjmwedkskb0880dbd541fbe1ca1a045e.jpg",
            'email' => "partner@gmail.com",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("partner");
        User::create([
            'first_name' => "student",
            'last_name' => "student",
            'avatar' => "fjmwedkskb0880dbd541fbe1ca1a045e.jpg",
            'email' => "student@gmail.com",
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("student");


//

//
    }

}
