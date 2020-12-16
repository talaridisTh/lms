<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Material;
use App\Models\Course;
use App\Models\Bundle;
use App\Models\Role;
use App\Models\Topic;
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
            OptionSeeder::class,
            RoleSeeder::class,
            TopicSeeder::class,
            UserSeeder::class,
        ]);

        User::factory()->times(500)->create()
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
                $course->topics()->attach(Topic::all()->random()->id);
                for ($i = 0; $i < 20; $i ++)
                {
                    $course->users()->attach(User::whereNotIn('id', [1,3,5,6,7,8])->get()->random()->id);
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
