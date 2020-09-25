<?php

use App\Course;
use App\User;
use Database\Seeders\MessageSeeder;
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
			})->each( function($user) {


			    if ($user->getRoleNames()[0]=="instructor"){
                    do
                    {
                        $from = rand(1, 30);
                        $to = rand(1, 30);
                        $read = rand(0, 1);
                    } while ($from === $to);


                    factory( App\Message::class)->create([
                        "from" => $from,
                        "to" => $to,
                        "message" => '$faker->sentence',
                        "read" => rand(1, 0)
                    ]);
                }


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
