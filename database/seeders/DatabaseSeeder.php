<?php

namespace Database\Seeders;

use App\Course;
use App\User;
use App\Material;
use App\Role;
use App\Topic;
use App\Bundle;
use App\Section;
use Database\Seeders\MessageSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

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
			TopicSeeder::class,
			UserSeeder::class,
		]);
		
		User::factory()->times(100)->create()
			->each( function($user) {
        		$user->roles()->attach( rand( 2, 4 ) );
			});

		Material::factory()->times(80)->create()
			->each( function($material) {

				$material->users()->attach( Role::find(2)->users()->select("id")->get()->random()->id);
			});

		Course::factory()->times(30)->create()
			->each( function($course) {
				$course->topics()->attach( Topic::all()->random()->id);
				for ( $i = 0; $i < 20; $i++) {
					$course->users()->attach(User::where('id', '!=', 1)->get()->random()->id);

					$course->materials()->attach( Material::all()->random()->id, ["priority" => rand( 1, 10000 )]);
				}
			});

		Section::factory()->times(90)
			->state(function() {

				$material = Material::where("type", "Section")->get()->random();

				return [
					"parent_id" => $material->id,
					"course_id" => Course::all()->random()->id,
					"title" => $material->title,
					"slug" => $material->slug,
				];

			})->create()->each( function($section) {

				$rand = rand(2, 5);
				$year = rand(2019, 2022);
				$month = rand(1, 12);
				$day = rand(1, 31);
				$hours = rand(0, 23);
				$mins = rand(0, 59);
				$secs = rand(0, 59);
				$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);

				for ( $i = 0; $i < $rand; $i++) {
					$section->materials()->attach( Material::all()
						->random()->id, ["priority" => rand( 1, 255 ), "status" => rand(0,1), "publish_at" => $date]);
				}

			});

		Bundle::factory()->times(15)->create()
			->each( function($bundle) {
				for( $i = 0; $i < 5; $i++ ) {
					$bundle->courses()->attach(Course::all()->random()->id);
				}
				for ( $i = 0; $i < 20; $i++ ) {
					$bundle->users()->attach(Role::find(4)->users()->select("id")->get()->random()->id);
				}
			});

	}
}
