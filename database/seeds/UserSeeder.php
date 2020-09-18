<?php

use App\Course;
use App\Topic;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
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

       $admin= User::create([
            'first_name' => "admin",
            'last_name' => "admin",
            'email' => "admin@gmail.com",
            "phone"=>"6978565698",
            "profil"=>"admin profil",
            'cover' => "http://lorempixel.com/80/80/people",
            'slug' => "admin",
            'password' => Hash::make('password'),
            "password_encrypt"=>Crypt::encryptString('password'),
            'status' => 1,
            'remember_token' => Str::random(10),
		])->assignRole("admin")
            ->each( function() {
              $javascript =  Course::create([
                        'title' => "Javascript",
                        "subtitle"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dignissim pulvinar metus quis bibendum. Donec fermentum porta consequat. Pellentesque vestibulum magna convallis, consequat neque a.",
                        "summary"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dignissim pulvinar metus quis bibendum. Donec fermentum porta consequat. Pellentesque vestibulum magna convallis, consequat neque a.",
                        "cover"=>"https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRuHnJDLOcdm_0b6N6kNj-1OvO9KhKYgqIy0w&usqp=CAU",
                        "description"=>'<div class="row"><div class="col-6"><p class="text-wrap"><br><!--StartFragment-->Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dignissim <br>pulvinar metus quis bibendum. Donec fermentum porta consequat. <br>Pellentesque vestibulum magna convallis, consequat neque a.<!--EndFragment--><br></p></div><div class="col-6"><blockquote><p class="text-wrap">Quote...</p><p class="text-wrap"><cite>Author Attribution<br><!--StartFragment-->Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dignissim <br>pulvinar metus quis bibendum. Donec fermentum porta consequat. <br>Pellentesque vestibulum magna convallis, consequat neque a.<!--EndFragment--><br><br></cite></p></blockquote></div></div>',
                        "user_id"=>2,
                        "slug"=>"javascript",
                        "version"=>"Trial",
                        "status"=>1,
                        "publish_at"=>now()
                    ]
                );
                $javascript->users()->sync(User::find(1));
                $javascript->topics()->sync(Topic::find(1));
                $javascript->materials()->create([
                    'title' => "Variables",
                    'slug' => "Variables",
                    'subtitle' => "sagittis, quis sagittis ex convallis. Pellentesque suscipit, neque vitae finibus pretium. ",
                    'summary' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim odio sit amet magna sagittis, quis sagittis ex convallis. Pellentesque suscipit, neque vitae finibus pretium. ",
                    'cover' => "https://img-a.udemycdn.com/course/750x422/1929394_4932_4.jpg",
                    'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim odio sit amet magna sagittis, quis sagittis ex convallis. Pellentesque suscipit, neque vitae finibus pretium. ",
                    'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim odio sit amet magna sagittis, quis sagittis ex convallis. Pellentesque suscipit, neque vitae finibus pretium. ",
                    'status' => "1",
                    'type' => "Lesson",


                ],["priority"=>1 ,"status"=>1]);

               $laravel =   Course::create([
                    'title' => "Laravel",
                    "subtitle"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dignissim pulvinar metus quis bibendum. Donec fermentum porta consequat. Pellentesque vestibulum magna convallis, consequat neque a.",
                    "summary"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dignissim pulvinar metus quis bibendum. Donec fermentum porta consequat. Pellentesque vestibulum magna convallis, consequat neque a.",
                    "cover"=>"https://cdn.slidesharecdn.com/ss_thumbnails/kickstartmv-techtalk-on-laravel-140526012910-phpapp01-thumbnail-4.jpg?cb=1401068117",
                    "user_id"=>2,
                    "slug"=>"laravel",
                    "version"=>"Trial",
                    "status"=>1,
                    "publish_at"=>now()
                ]);
                $laravel->users()->sync(User::find(1));
                $laravel->topics()->sync(Topic::find(2));
                $laravel->materials()->create([
                    'title' => "Controller",
                    'slug' => "controller",
                    'subtitle' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim odio sit amet magna sagittis, quis sagittis ex convallis. Pellentesque suscipit, neque vitae finibus pretium. ",

                    'summary' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim odio sit amet magna sagittis, quis sagittis ex convallis. Pellentesque suscipit, neque vitae finibus pretium. ",
                    'cover' => "https://miro.medium.com/max/960/1*Vu2ThQPxr72UEOP0LMo4hA.jpeg",
                    'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim odio sit amet magna sagittis, quis sagittis ex convallis. Pellentesque suscipit, neque vitae finibus pretium. ",
                    'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim odio sit amet magna sagittis, quis sagittis ex convallis. Pellentesque suscipit, neque vitae finibus pretium. ",
                    'status' => "1",
                    'type' => "Link",
                    'video_Link' => "43014286",


                ],["priority"=>1 ,"status"=>1]);

            });








		User::create([
            'first_name' => "Υδρόγειος",
            'last_name' => "Idrogios",
            'cover' => "http://lorempixel.com/80/80/people",
            'email' => "idrogios@gmail.com",
            "phone"=>"6978512598",
            "profil"=>"

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim odio sit amet magna sagittis, quis sagittis ex convallis. Pellentesque suscipit, neque vitae finibus pretium. ",
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
            'cover' => "6176c9b44bf3aa29b77b8d335ec4d38d.jpg",
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
            'cover' => "6176c9b44bf3aa29b77b8d335ec4d38d.jpg",
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
            'cover' => "6176c9b44bf3aa29b77b8d335ec4d38d.jpg",
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
            'cover' => "6176c9b44bf3aa29b77b8d335ec4d38d.jpg",
            'slug' => "trial-user",
            'password' => Hash::make('password'),
            "password_encrypt"=>Crypt::encryptString('password'),
            'status' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("trial user");






//

//
    }

}
