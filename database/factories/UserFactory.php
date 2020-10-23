<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		$year = rand(2018, 2020);
    	$month = rand(1, 12);
    	$day = rand(1, 31);
    	$hours = rand(0, 23);
    	$mins = rand(0, 59);
    	$secs = rand(0, 59);
		$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);

        return [
            'first_name' => $this->faker->firstName,
        	'last_name' => $this->faker->lastName,
        	'email' => $this->faker->unique()->safeEmail,
        	'phone' => 69 . $this->faker->numberBetween(3, 9) . $this->faker->randomNumber(7, false),
        	'profil' => $this->faker->sentence,
        	'cover' => "/images/avatar-placeholder.png",
        	"slug" => Str::slug($this->faker->firstName.$this->faker->lastName, '-'),
        	'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        	'password_encrypt' => Crypt::encryptString('password'), // password
        	'status' => $this->faker->numberBetween(0, 1),
        	'remember_token' => Str::random(10),
        	'created_at' => $date->format('Y-m-d H:i:s'),
        	'email_verified_at' => rand(1, 4) === 4 ? null : $date->addMinutes(rand(5, 180))->format('Y-m-d H:i:s'),
        	'updated_at' => $date->addWeeks(rand(1, 12))->subSeconds(rand(36000, 136000))->format('Y-m-d H:i:s')
        ];
    }
}
