<?php

namespace Database\Seeders;

use App\Comment;
use App\Course;
use App\Material;
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
        $this->call([
            RoleSeeder::class,
		]);

		Utility::factory()->create();

        User::factory()->times(100)->create()
            ->each(function ($user) {
                $user->roles()->attach(rand(2, 4));
            });

        Material::factory()->times(80)->create()
            ->each(function ($material) {

                $material->users()->attach(Role::find(2)->users()->select("id")->get()->random()->id);
                if ($material->type == "Section")
                {
                    for ($i = 0; $i < 5; $i ++)
                    {
                        $material->chapters()->attach(rand(1, 80), ["priority" => $i + 1]);
                    }
                }
            });

        Course::factory()->times(30)->create()
            ->each(function ($course) {
                for ($i = 0; $i < 20; $i ++)
                {
                    $course->users()->attach(User::whereNotIn('id', [1,3,5])->get()->random()->id);
                    $course->materials()->attach(rand(1, 80), ["priority" => $i + 1]);
                }
            });

        Post::factory()->times(15)->create();




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
            'first_name' => "darkpony",
            'last_name' => "darkpony",
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
