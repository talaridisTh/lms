<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Material;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;


$factory->define(Material::class, function (Faker $faker) {

	static $counter = 3;

	$year = rand(2015, 2020);
	$month = rand(1, 12);
	$day = rand(1, 31);
	$hours = rand(0, 23);
	$mins = rand(0, 59);
	$secs = rand(0, 59);

	$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);



    return [
		'title' => "Title of Lesson ".$counter ,
		'subtitle' => "Subtitle of Lesson ".$counter ,
		'cover' => $faker->imageUrl(),
		'description' => "Description of Lesson ".$counter ,
		'content' => "Content of Lesson ".$counter++ ,
		'status' => rand( 0, 1 ),
		'slug' => $faker->slug,
		'type' => $faker->numberBetween( 0, 1) == 0 ? "Lesson" : $faker->fileExtension,
		'created_at' => $date->format('Y-m-d H:i:s'),
		'updated_at' => $date->addWeeks(rand(1, 12))->subSeconds(rand(36000, 136000))->format('Y-m-d H:i:s')
    ];
});
