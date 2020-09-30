<?php

namespace Database\Factories;

use App\Bundle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BundleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bundle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
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
			'cover' => $this->faker->imageUrl(),
			'slug' => $this->faker->slug,
			'status' => $this->faker->numberBetween( 0, 1 ),
			'created_at' => $date->format('Y-m-d H:i:s'),
			'updated_at' => $date->addWeeks( rand(1, 12) )->subSeconds( rand(36000, 136000) )->format('Y-m-d H:i:s'),
			'publish_at' => $date->addYears( rand(1, 2) ),
        ];
    }
}
