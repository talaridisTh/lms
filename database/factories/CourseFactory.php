<?php

namespace Database\Factories;

use App\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

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
		$status = rand(0, 1);

		$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);

        return [
            'title' => "Title of Course ".$counter,
        	'subtitle' => "Subtitle of Course ".$counter,
        	'summary' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        	'cover' => "http://placeimg.com/1600/900/any",
			'description' => "Description of Course ".$counter++." ".$this->faker->slug($nbSentences = 3, $variableNbSentences = true),
			'user_id' => 2,
			'slug' => $this->faker->slug,
			'status' => $status,
			'version' => $this->faker->numberBetween( 0 , 1 ) == 0 ? "Trial" : "Normal",
			'fields' => json_encode(["summary" => rand(0,1), "description" => rand(0,1)]),
			'created_at' => $date->format('Y-m-d H:i:s'),
			'updated_at' => $date->addWeeks( rand(1, 12) )->subSeconds( rand(36000, 136000) )->format('Y-m-d H:i:s'),
			'publish_at' => $status == 1 ? $date->addYears( rand(1, 2) ) : null,
        ];
    }
}
