<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Course::class, 5)->create()
            ->each(function ($course) {
                $course->materials()->saveMany(factory(App\Material::class, 5)->create(["type"=>$course->name]))
                    ->each(function($material){
                        $material->topics()->saveMany(factory(App\Topic::class, 2)->create());
            });
    });

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
}




}


