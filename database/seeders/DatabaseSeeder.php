<?php

namespace Database\Seeders;

use App\Comment;
use App\Course;
use App\Material;
use App\Option;
use App\Post;
use App\Role;
use App\Topic;
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

        Option::create([
            "name" => "Image Dimensions",
            "value" => json_encode([
                "thumbnail" => [
                    "style" => [
                        "w" => 400,
                        "h" => 400,
                        "fit" => "crop"
                    ]
                ],
                "card-small" => [
                    "style" => [
                        "w" => 400,
                        "h" => 225,
                        "fit" => "crop"
                    ]
                ],
                "card-medium" => [
                    "style" => [
                        "w" => 600,
                        "h" => 377,
                        "fit" => "crop"
                    ]
                ],
                "rounded-small" => [
                    "style" => [
                        "w" => 100,
                        "h" => 100,
                        "fit" => "crop"
                    ]
                ],
                "rounded-medium" => [
                    "style" => [
                        "w" => 200,
                        "h" => 200,
                        "fit" => "crop"
                    ]
                ]
            ]),
            "slug" => "image-dimensions"
        ]);
        $this->call([
            RoleSeeder::class,
        ]);
//        Post::factory()->times(15)->create();
        $user = new user;
        $user->first_name = "admin";
        $user->last_name = "admin";
        $user->email = "admin@gmail.com";
        $user->phone = "6978565698";
        $user->profil = "admin profil";
        $user->avatar = "/images/avatar-placeholder.png";
        $user->slug = "admin";
        $user->password = Hash::make('password');
        $user->password_encrypt = Crypt::encryptString('password');
        $user->status = 1;
        $user->remember_token = Str::random(10);
        $user->save();
        $user->assignRole("admin");

//        User::create([
//            'first_name' => "admin",
//            'last_name' => "admin",
//            'email' => "admin@gmail.com",
//            "phone" => "6978565698",
//            "profil" => "admin profil",
//            'avatar' => "/images/avatar-placeholder.png",
//            'slug' => "admin",
//            'password' => Hash::make('password'),
//            "password_encrypt" => Crypt::encryptString('password'),
//            'status' => 1,
//            'remember_token' => Str::random(10),
//        ]);
//        User::create([
//            'first_name' => "darkpony",
//            'last_name' => "darkpony",
//            'email' => "info@darkpony.com",
//            "phone" => "6978565698",
//            "profil" => "darkpony",
//            'avatar' => "/images/avatar-placeholder.png",
//            'slug' => "darkpony-super",
//            'password' => Hash::make('darkpony'),
//            "password_encrypt" => Crypt::encryptString('darkpony'),
//            'status' => 1,
//            'remember_token' => Str::random(10),
//        ])->assignRole("super-admin");
    }

}
