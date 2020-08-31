<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CourseMaterial;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(CourseMaterial::class, function (Faker $faker) {

	$year = rand(2018, 2021);
	$month = rand(1, 12);
	$day = rand(1, 31);
	$hours = rand(0, 23);
	$mins = rand(0, 59);
	$secs = rand(0, 59);

	$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);

    return [
		'course_id' => $faker->numberBetween( 1, 15),
		'material_id' => $faker->numberBetween( 1, 10),
		'status' => $faker->numberBetween( 0, 1 ),
		'priority' => $faker->numberBetween( 1, 10000),
		'publish_at' => $date
    ];
});
