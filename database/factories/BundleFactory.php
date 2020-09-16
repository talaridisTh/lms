<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundle;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Bundle::class, function (Faker $faker) {

	static $counter = 1;

	$year = rand(2015, 2020);
	$month = rand(1, 12);
	$day = rand(1, 31);
	$hours = rand(0, 23);
	$mins = rand(0, 59);
	$secs = rand(0, 59);

	$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);

    return [
        'title' => "Title of Bundle ".$counter,
        'subtitle' => "Subtitle of Bundle ".$counter,
		'summary' => "Summary of Bundle ".$counter,
		'description' => "Description of Bundle ".$counter++,
		'cover' => $faker->md5 .".jpg",
		'slug' => $faker->slug,
		'status' => $faker->numberBetween( 0, 1 ),
		'created_at' => $date->format('Y-m-d H:i:s'),
		'updated_at' => $date->addWeeks( rand(1, 12) )->subSeconds( rand(36000, 136000) )->format('Y-m-d H:i:s'),
		'publish_at' => $date->addYears( rand(1, 2) ),
    ];
});
