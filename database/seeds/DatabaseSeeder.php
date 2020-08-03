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
        $this->call(RoleSeeder::class);
		$this->call(UserSeeder::class);
		$this->call(TopicSeeder::class);
		


		factory(App\Bundle::class, 3)->create()
		->each(function ($bundle) {

			$bundle->courses()->saveMany(factory(App\Course::class, 5)->create()
			->each(function($course) {

				$course->users()->saveMany(factory(App\User::class, 5)->create())
				->each(function($user) {

					$rand = rand( 0, 1 );
                    $roles = [ 'instructor', 'student' ];
					$user->assignRole($roles[$rand]);
					
				});
			}));
        });

		factory(App\Material::class, 10)->create()
		->each(function ($materials) {
			
			$materials->topics()->attach(App\Topic::all()->random()->id);
            $materials->users()->saveMany(factory(App\User::class, 2)->create())
            ->each(function ($user) {

                $user->assignRole('instructor');
            
            });
        });

		// an mpei epano oi users den exoun dimiourgi8ei akomi kai petaei errors
		$this->call(CourseMaterialSeeder::class);

    }

}