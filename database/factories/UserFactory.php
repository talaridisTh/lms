<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {

	$year = rand(2015, 2020);
	$month = rand(1, 12);
	$day = rand(1, 31);
	$hours = rand(0, 23);
	$mins = rand(0, 59);
	$secs = rand(0, 59);

	$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' =>$faker->creditCardNumber,
        'profil' => $faker->sentence,
        'avatar' => "https://robohash.org/$faker->firstName.png?set=set5",
        "slug"=> Str::slug($faker->firstName,"-"),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'active' => $faker->numberBetween( 0, 1 ),
        'remember_token' => Str::random(10),
        'created_at' => $date->format('Y-m-d H:i:s'),
        'email_verified_at' => $date->addMinutes(rand(5, 180))->format('Y-m-d H:i:s'),
		'updated_at' => $date->addWeeks(rand(1, 12))->subSeconds(rand(36000, 136000))->format('Y-m-d H:i:s')
    ];
});
