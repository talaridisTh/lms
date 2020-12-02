<?php

namespace Database\Seeders;


use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
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
            OptionSeeder::class,
            RoleSeeder::class,
        ]);

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

       User::create([
           'first_name' => "Darkpony",
           'last_name' => "Digital",
           'email' => "info@darkpony.com",
           "phone" => "6978565698",
           "profil" => "darkpony",
           'avatar' => "/images/avatar-placeholder.png",
           'slug' => "darkpony-super",
           'password' => Hash::make('darkpony'),
           "password_encrypt" => Crypt::encryptString('darkpony'),
           'status' => 1,
           'remember_token' => Str::random(10),
       ])->assignRole("super-admin");

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
    }

}
