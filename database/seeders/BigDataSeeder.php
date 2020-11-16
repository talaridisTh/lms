<?php

namespace Database\Seeders;

use App\User;
use App\Material;
use App\Course;
use App\Bundle;
use App\Role;
use App\Topic;
use Database\Seeders\MessageSeeder;
use Illuminate\Database\Seeder;

class BigDataSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            TopicSeeder::class,
            UserSeeder::class,
            UtilitySeeder::class,
        ]);
        User::factory()->times(500)->create()
            ->each(function ($user) {
                $user->roles()->attach(rand(3, 4));
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
                $course->topics()->attach(Topic::all()->random()->id);
                for ($i = 0; $i < 20; $i ++)
                {
                    $course->users()->attach(User::where('id', '!=', 1)->get()->random()->id);
                    $course->materials()->attach(rand(1, 80), ["priority" => $i + 1]);
                }
            });
        Bundle::factory()->times(15)->create()
            ->each(function ($bundle) {
                for ($i = 0; $i < 5; $i ++)
                {
                    $bundle->courses()->attach(Course::all()->random()->id);
                }
                for ($i = 0; $i < 20; $i ++)
                {
                    $bundle->users()->attach(Role::find(4)->users()->select("id")->get()->random()->id);
                }
            });
    }

}
