<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CourseMaterial;
use Faker\Generator as Faker;

$factory->define(CourseMaterial::class, function (Faker $faker) {

    return [
		'course_id' => $faker->numberBetween( 1, 15),
		'material_id' => $faker->numberBetween( 1, 10),
		'active' => $faker->numberBetween( 1, 10000),
		'priority' => $faker->numberBetween( 1, 10000)
    ];
});
