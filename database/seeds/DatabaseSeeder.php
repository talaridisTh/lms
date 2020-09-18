<?php

use App\Course;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(TopicSeeder::class);
        $this->call(UserSeeder::class);

        factory( App\User::class, 100)->create()
			->each( function($user) {
        		$user->assignRole(Arr::random([ 'instructor', 'student','partner' ]));
			});

		factory( App\Material::class, 80)->create()
			->each( function($material) {

			    $material->update(['type'=>Arr::random(['Announcement','Video','Link',"Lesson","Lesson"])]);
				$material->users()->attach(App\Role::find(2)->users()->select("id")->get()->random()->id);
			});

		factory( App\Course::class, 30)->create()
			->each( function($course) {
                $course->topics()->attach(App\Topic::all()->random()->id);
				for ( $i = 0; $i < 20; $i++) {
					$course->users()->attach(User::where('id', '!=', 1)->get()->random()->id);

					$course->materials()->attach(App\Material::all()->random()->id, ["priority" => rand( 1, 10000 )]);
				}
			});

		factory( App\Bundle::class, 15)->create()
			->each( function($bundle) {
				for( $i = 0; $i < 5; $i++ ) {
					$bundle->courses()->attach(App\Course::all()->random()->id);
				}
				for ( $i = 0; $i < 20; $i++ ) {
					$bundle->users()->attach(App\Role::find(4)->users()->select("id")->get()->random()->id);
				}
			});



	}
}
