<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Material;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;


$factory->define(Material::class, function (Faker $faker) {

	static $counter = 1;

	$year = rand(2015, 2020);
	$month = rand(1, 12);
	$day = rand(1, 31);
	$hours = rand(0, 23);
	$mins = rand(0, 59);
	$secs = rand(0, 59);

	$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);



    return [
		'name' => "Name of Lesson ".$counter ,
		'cover' => $faker->imageUrl(),
		'small_description' => "Small Description of Lesson ".$counter ,
		'description' => "Description of Lesson ".$counter++ ,
		'active' => rand( 0, 1 ),
		'slug' => $faker->slug,
		'type' => $faker->numberBetween( 0, 1) == 0 ? "Lesson" : $faker->fileExtension,
		'created_at' => $date->format('Y-m-d H:i:s'),
		'updated_at' => $date->addWeeks(rand(1, 12))->subSeconds(rand(36000, 136000))->format('Y-m-d H:i:s')
    ];
});
