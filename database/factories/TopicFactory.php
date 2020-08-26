<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Topic;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Topic::class, function (Faker $faker) {

	static $counter = 1;

	$year = rand(2015, 2020);
	$month = rand(1, 12);
	$day = rand(1, 31);
	$hours = rand(0, 23);
	$mins = rand(0, 59);
	$secs = rand(0, 59);

	$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);

    return [
        'title' => "Topic Title ". $counter++,
        'created_at' => $date->format('Y-m-d H:i:s'),
		'updated_at' => $date->addWeeks(rand(1, 12))->subSeconds(rand(36000, 136000))->format('Y-m-d H:i:s')
    ];
});
