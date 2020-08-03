<?php

use App\Course;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        factory(App\Course::class, 5)->create()
            ->each(function ($course) {
                $course->users()->saveMany(factory(App\User::class, 5)->create())
                    ->each(function ($user) {
                        $user->assignRole('student');
                    });

                $course->materials()->saveMany(factory(App\Material::class, 5)->create())
                    ->each(function ($material) {
                        $material->topics()->saveMany(factory(App\Topic::class, 2)->create());
                    })

                    ->each(function ($material) {
                        $material->users()->saveMany(factory(App\User::class, 2)->create())
                            ->each(function ($user) {
                                $user->assignRole('instructor');
                                $user->courses()->attach(App\Course::all()->random()->id);
                            });

                    });
            });



    }

}


